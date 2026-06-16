<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceRecord extends Model
{
    public const STATUS_PRESENT = 'present';
    public const STATUS_ABSENT = 'absent';
    public const STATUS_LATE = 'late';
    public const STATUS_EXCUSED = 'excused';

    public const STATUSES = [
        self::STATUS_PRESENT,
        self::STATUS_ABSENT,
        self::STATUS_LATE,
        self::STATUS_EXCUSED,
    ];

    protected $fillable = [
        'user_id',
        'record_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'record_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function statusLabel(): string
    {
        switch ($this->status) {
            case self::STATUS_PRESENT:
                return 'Present';
            case self::STATUS_ABSENT:
                return 'Absent';
            case self::STATUS_LATE:
                return 'Late';
            case self::STATUS_EXCUSED:
                return 'Excused';
            default:
                return ucfirst($this->status);
        }
    }
}
