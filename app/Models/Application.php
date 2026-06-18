<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    public const STATUS_NEW = 'new';
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'student_id_number',
        'date_of_birth',
        'gender',
        'school_name',
        'home_address',
        'guardian_name',
        'guardian_contact_number',
        'emergency_contact_number',
        'course',
        'course_id',
        'message',
        'status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function scopePendingReview($query)
    {
        return $query->whereIn('status', [self::STATUS_NEW, self::STATUS_PENDING]);
    }

    public function isPendingReview(): bool
    {
        return in_array($this->status, [self::STATUS_NEW, self::STATUS_PENDING], true);
    }

    public function courseRelation()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
