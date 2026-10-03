<?php

use App\Models\Activity;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Activitylog\Facades\Activity as ActivityFacade;

it('logs activities with a uuid id and uuid causer/subject keys', function () {
    $komting = User::factory()->create();
    $mahasiswa = User::factory()->create();

    $activity = ActivityFacade::performedOn($mahasiswa)
        ->causedBy($komting)
        ->event('role.changed')
        ->withProperty('role', 'mahasiswa')
        ->log('Role of user changed to mahasiswa');

    expect($activity)->toBeInstanceOf(Activity::class)
        ->and($activity->id)->toBeString()
        ->and(Str::isUuid($activity->id))->toBeTrue()
        ->and($activity->causer_type)->toBe(User::class)
        ->and($activity->causer_id)->toBe($komting->id)
        ->and($activity->subject_type)->toBe(User::class)
        ->and($activity->subject_id)->toBe($mahasiswa->id)
        ->and($activity->event)->toBe('role.changed')
        ->and($activity->causer->is($komting))->toBeTrue()
        ->and($activity->properties['role'])->toBe('mahasiswa');
});

it('resolves the authenticated user as causer automatically', function () {
    $komting = User::factory()->create();
    $subject = User::factory()->create();

    $this->actingAs($komting);

    $activity = ActivityFacade::performedOn($subject)
        ->event('role.changed')
        ->log('Role of user changed');

    expect($activity->causer_type)->toBe(User::class)
        ->and($activity->causer_id)->toBe($komting->id);
});

it('stores activity log rows with uuid primary keys in the database', function () {
    $user = User::factory()->create();

    ActivityFacade::performedOn($user)->event('student.created')->log('User created');

    $row = DB::table('activity_log')->first();

    expect($row)->not->toBeNull()
        ->and(Str::isUuid($row->id))->toBeTrue()
        ->and($row->causer_id === null || Str::isUuid($row->causer_id))->toBeTrue()
        ->and(Str::isUuid($row->subject_id))->toBeTrue();
});
