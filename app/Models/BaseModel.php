<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * Base class for all domain models.
 *
 * Project convention: every domain table uses a UUID primary key,
 * so every domain model must generate and hydrate UUIDs.
 */
abstract class BaseModel extends Model
{
    use HasUuids;
}
