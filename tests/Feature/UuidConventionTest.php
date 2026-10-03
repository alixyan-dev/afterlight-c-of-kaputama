<?php

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use function Pest\Laravel\seed;

it('saves users with a uuid primary key', function () {
    $user = User::factory()->create();

    expect($user->id)->toBeString()
        ->and(Str::isUuid($user->id))->toBeTrue()
        ->and($user->is_active)->toBeTrue();
});

it('creates uuid ids for roles and permissions', function () {
    seed(RolePermissionSeeder::class);

    $role = Role::where('name', 'komting')->firstOrFail();
    $permission = Permission::where('name', 'roles.assign')->firstOrFail();

    expect(Str::isUuid($role->id))->toBeTrue()
        ->and(Str::isUuid($permission->id))->toBeTrue();
});

it('assigns roles to users through uuid foreign key relations', function () {
    seed(RolePermissionSeeder::class);

    $user = User::factory()->create();
    $user->assignRole('mahasiswa');

    expect($user->hasRole('mahasiswa'))->toBeTrue()
        ->and($user->can('materials.download'))->toBeTrue()
        ->and($user->can('payments.approve'))->toBeFalse();

    $modelId = DB::table('model_has_roles')->where('model_type', User::class)->value('model_id');

    expect(Str::isUuid($modelId))->toBeTrue()
        ->and($modelId)->toBe($user->id);
});

it('maps permissions to roles according to the design matrix', function () {
    seed(RolePermissionSeeder::class);

    $komting = Role::where('name', 'komting')->firstOrFail();
    $bendahara = Role::where('name', 'bendahara')->firstOrFail();
    $mahasiswa = Role::where('name', 'mahasiswa')->firstOrFail();

    expect($komting->hasPermissionTo('users.manage'))->toBeTrue()
        ->and($komting->hasPermissionTo('payments.approve'))->toBeTrue()
        ->and($bendahara->hasPermissionTo('payments.approve'))->toBeTrue()
        ->and($bendahara->hasPermissionTo('attendance.validate'))->toBeFalse()
        ->and($mahasiswa->hasPermissionTo('payments.submit-proof'))->toBeTrue()
        ->and($mahasiswa->hasPermissionTo('payments.approve'))->toBeFalse();
});

it('can be re-run without duplicating roles or permissions', function () {
    seed(RolePermissionSeeder::class);
    seed(RolePermissionSeeder::class);

    expect(Role::where('name', 'komting')->count())->toBe(1)
        ->and(Permission::where('name', 'roles.assign')->count())->toBe(1);
});
