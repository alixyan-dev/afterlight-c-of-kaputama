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
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
