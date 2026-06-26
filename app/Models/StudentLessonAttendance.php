<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentLessonAttendance extends Model
{
    protected $fillable = [
        'user_id',
        'lesson_id',
        'attended_at',
    ];

    protected $casts = [
        'attended_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function isAttended(): bool
    {
        return $this->attended_at !== null;
    }
}
