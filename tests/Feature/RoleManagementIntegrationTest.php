<?php

use App\Models\Activity;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use function Pest\Laravel\seed;

it('komting assigns a role to mahasiswa and writes a uuid audit log', function () {
    seed(RolePermissionSeeder::class);    $komting = User::factory()->create();
    $mahasiswa = User::factory()->create();
    $komting->assignRole('komting');

    $this->actingAs($komting);

    $response = $this->post(route('users.roles.assign', $mahasiswa), [
        'role_name' => 'mahasiswa',
        'user_id' => $mahasiswa->id,
    ]);

    $response->assertRedirect();
    $mahasiswa->refresh();

    expect($mahasiswa->hasRole('mahasiswa'))->toBeTrue()
        ->and(Str::isUuid($mahasiswa->id))->toBeTrue();

    $log = DB::table('activity_log')
        ->where('event', 'role.changed')
        ->where('causer_id', $komting->id)
        ->where('subject_id', $mahasiswa->id)
        ->first();

    expect($log)->not->toBeNull()
        ->and(Str::isUuid($log->id))->toBeTrue()
        ->and(Str::isUuid($log->causer_id))->toBeTrue()
        ->and(Str::isUuid($log->subject_id))->toBeTrue();

    $activityModel = Activity::find($log->id);
    expect($activityModel)->not->toBeNull()
        ->and($activityModel->causer->is($komting))->toBeTrue();
});
