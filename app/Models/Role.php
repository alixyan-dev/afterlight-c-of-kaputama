<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Permission\Models\Role as SpatieRole;

/**
 * Role model with UUID primary key.
 *
 * Extends the spatie/laravel-permission Role model so the published
 * permission tables (which use UUID ids and uuidMorphs) stay consistent.
 *
 * @property string $id
 */
class Role extends SpatieRole
{
    use HasUuids;
}
