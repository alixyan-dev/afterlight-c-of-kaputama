<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * Student profile for class members.
 *
 * @property string $id
 * @property string $user_id
 * @property string $npm
 * @property string|null $class_name
 * @property string|null $phone
 * @property string $status
 */
class StudentProfile extends BaseModel
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'npm',
        'class_name',
        'phone',
        'status',
    ];

    protected $attributes = [
        'status' => 'active',
    ];

    /**
     * The student belongs to a user account.
     */
    public function scopeSearch(\Illuminate\Database\Eloquent\Builder $query, ?string $search): \Illuminate\Database\Eloquent\Builder
    {
        if (! $search) {
            return $query;
        }

        return $query->where('name', 'ilike', "%{$search}%")
            ->orWhere('email', 'ilike', "%{$search}%");
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeSearch(\Illuminate\Database\Eloquent\Builder $query, ?string $search): \Illuminate\Database\Eloquent\Builder
    {
        if (! $search) {
            return $query;
        }

        return $query->where('npm', 'ilike', "%{$search}%")
            ->orWhere('class_name', 'ilike', "%{$search}%")
            ->orWhere('phone', 'ilike', "%{$search}%");
    }
}
