<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InitialKomtingUserSeeder extends Seeder
{
    /**
     * Seed the initial komting (administrator) account.
     *
     * Credentials are read from config (see config/komting.php, backed by
     * env vars) so no secret is ever stored in code:
     *
     *   KOMTING_USER_EMAIL      - required; skipped if empty
     *   KOMTING_USER_NAME       - optional; defaults to "Komting"
     *   KOMTING_USER_PASSWORD   - optional; a random one is generated
     *                            and printed when left empty
     *
     * The seeder is idempotent: re-running it will not duplicate the user
     * and will simply ensure the account is active and has the komting role.
     */
    public function run(): void
    {
        $email = (string) config('komting.user.email', '');

        if ($email === '') {
            $this->console('KOMTING_USER_EMAIL is not set. Skipping the initial komting user.', 'warn');

            return;
        }

        $role = Role::firstOrCreate(['name' => 'komting']);

        $user = User::firstOrNew(['email' => $email]);

        if (! $user->exists) {
            $providedPassword = (string) config('komting.user.password', '');

            $user->name = (string) config('komting.user.name', 'Komting');
            $user->password = $providedPassword === '' ? Str::password(20, symbols: true) : $providedPassword;
            $user->is_active = true;
            $user->save();

            if ($providedPassword === '') {
                $this->console('No KOMTING_USER_PASSWORD provided; a random password was generated. Store it securely and update it from the application.', 'warn');
            }
        }

        if (! $user->hasRole('komting')) {
            $user->syncRoles($role);
        }

        $this->console("Initial komting user is ready: {$user->email}", 'info');
    }

    /**
     * Write to the console when a command instance is available.
     */
    private function console(string $message, string $style = 'info'): void
    {
        if ($this->command === null) {
            return;
        }

        $method = match ($style) {
            'warn' => 'warn',
            'error' => 'error',
            default => 'info',
        };

        $this->command->$method($message);
    }
}
