<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Activitylog\Models\Activity as SpatieActivity;

/**
 * Audit log model with UUID primary key.
 *
 * Extends the spatie/laravel-activitylog Activity model so the
 * activity_log table (which uses a UUID id and nullableUuidMorphs
 * for causer/subject) stays consistent with the project's UUID
 * convention.
 *
 * @property string $id
 * @property string|null $subject_id
 * @property string|null $causer_id
 */
class Activity extends SpatieActivity
{
    use HasUuids;
}
