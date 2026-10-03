<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DummyKomtingUserSeeder extends Seeder
{
    /**
     * Buat dummy user komting agar bisa login dan melihat tampilan manajemen role.
     *
     * Email/pw default digunakan untuk demo; ubah segera setelah login pertama.
     * Tidak menyimpan secret di code — hanya nilai demo yang jelas.
     */
    public function run(): void
    {
        $email = env('DUMMY_KOMTING_EMAIL', 'komting@kaputama.local');
        $password = env('DUMMY_KOMTING_PASSWORD', 'KomtingPass123');

        $user = User::firstOrNew(['email' => $email]);

        if (! $user->exists) {
            $user->name = env('DUMMY_KOMTING_NAME', 'Komting Demo');
            $user->password = bcrypt($password);
            $user->is_active = true;
            $user->save();
        }

        $user->assignRole('komting');

        $this->command?->line("Dummy komting ready: {$user->email} (UUID: {$user->id})");
    }
}
