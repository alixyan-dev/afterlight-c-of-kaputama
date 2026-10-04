<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Meeting extends Model
{
    use HasUuids;

    protected $fillable = [
        'course_id', 'semester_id', 'session_number', 'title', 'agenda',
        'location', 'meeting_date', 'start_time', 'end_time', 'status',
        'created_by', 'submitted_by', 'submitted_at', 'validated_by',
        'validated_at', 'notes',
    ];

    protected $casts = [
        'meeting_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'submitted_at' => 'datetime',
        'validated_at' => 'datetime',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
