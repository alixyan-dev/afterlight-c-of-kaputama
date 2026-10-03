<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Permission\Models\Permission as SpatiePermission;

/**
 * Permission model with UUID primary key.
 *
 * Extends the spatie/laravel-permission Permission model so the published
 * permission tables (which use UUID ids) stay consistent.
 *
 * @property string $id
 */
class Permission extends SpatiePermission
{
    use HasUuids;
}
