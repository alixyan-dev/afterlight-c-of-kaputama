<?php

use App\Models\User;
use Database\Seeders\InitialKomtingUserSeeder;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use function Pest\Laravel\seed;

beforeEach(function () {
    foreach (['KOMTING_USER_EMAIL', 'KOMTING_USER_NAME', 'KOMTING_USER_PASSWORD'] as $key) {
        putenv($key);
        unset($_ENV[$key], $_SERVER[$key]);
    }
});

function setTestEnv(string $key, ?string $value): void
{
    if ($value === null) {
        putenv($key);
        unset($_ENV[$key], $_SERVER[$key]);

        return;
    }

    putenv("{$key}={$value}");
    $_ENV[$key] = $value;
    $_SERVER[$key] = $value;
}

it('creates the initial komting user with a uuid, active status and komting role', function () {
    seed(RolePermissionSeeder::class);
    config()->set('komting.user.email', 'komting@example.com');
    config()->set('komting.user.name', 'Pak Komting');
    config()->set('komting.user.password', 'secret-password');

    seed(InitialKomtingUserSeeder::class);

    $user = User::where('email', 'komting@example.com')->firstOrFail();

    expect(Str::isUuid($user->id))->toBeTrue()
        ->and($user->name)->toBe('Pak Komting')
        ->and($user->is_active)->toBeTrue()
        ->and($user->hasRole('komting'))->toBeTrue()
        ->and($user->can('users.manage'))->toBeTrue()
        ->and(Hash::check('secret-password', $user->getAuthPassword()))->toBeTrue();
});

it('generates a random password when none is provided', function () {
    seed(RolePermissionSeeder::class);
    config()->set('komting.user.email', 'komting@example.com');

    seed(InitialKomtingUserSeeder::class);

    $user = User::where('email', 'komting@example.com')->firstOrFail();

    expect($user->getAuthPassword())->toHaveLength(60)
        ->and(Hash::check('komting@example.com', $user->getAuthPassword()))->toBeFalse();
});

it('is idempotent when run multiple times', function () {
    seed(RolePermissionSeeder::class);
    config()->set('komting.user.email', 'komting@example.com');
    config()->set('komting.user.password', 'secret-password');

    seed(InitialKomtingUserSeeder::class);
    seed(InitialKomtingUserSeeder::class);

    $user = User::where('email', 'komting@example.com')->firstOrFail();

    expect(User::where('email', 'komting@example.com')->count())->toBe(1)
        ->and(DB::table('model_has_roles')->where('model_id', $user->id)->count())->toBe(1)
        ->and(Hash::check('secret-password', $user->getAuthPassword()))->toBeTrue();
});

it('skips creation when no email is configured', function () {
    seed(InitialKomtingUserSeeder::class);

    expect(User::count())->toBe(0);
});
