<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'last_active_at',
        'attendance_percentage',
    ];

    public const ROLE_STUDENT = 'student';
    public const ROLE_ADMIN = 'admin';
    public const ROLE_TEACHER = 'teacher';

    public function lmsEnrollments()
    {
        return $this->hasMany(LmsEnrollment::class, 'user_id');
    }

    public function enrolledCourses()
    {
        return $this->hasManyThrough(Course::class, LmsEnrollment::class, 'user_id', 'id', 'id', 'course_id');
    }

    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class, 'user_id');
    }

    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class, 'user_id');
    }

    public function attendanceRecords()
    {
        return $this->hasMany(AttendanceRecord::class);
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function taughtLmsClasses()
    {
        return $this->hasMany(LmsClass::class, 'teacher_id');
    }

    public static function adminExists(): bool
    {
        return static::where('role', self::ROLE_ADMIN)->exists();
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isStudent(): bool
    {
        return $this->role === self::ROLE_STUDENT;
    }

    public function isTeacher(): bool
    {
        return $this->role === self::ROLE_TEACHER;
    }

    public static function emailIsConfiguredAdmin(?string $email): bool
    {
        if ($email === null || $email === '') {
            return false;
        }
        $allowed = config('viaanoor.admin_emails', []);
        return in_array(strtolower(trim($email)), $allowed, true);
    }

    /**
     * Promote user to admin if their email is in ADMIN_EMAILS (.env).
     */
    public function promoteIfConfiguredAdminEmail(): bool
    {
        if ($this->isAdmin()) {
            return false;
        }
        if (! self::emailIsConfiguredAdmin($this->email)) {
            return false;
        }
        $this->update(['role' => self::ROLE_ADMIN]);
        $this->refresh();
        return true;
    }

    public function ensureAdminWhenAdminOnlyMode(): bool
    {
        if (! config('viaanoor.admin_only_mode')) {
            return false;
        }
        if ($this->isAdmin()) {
            return false;
        }
        $this->update(['role' => self::ROLE_ADMIN]);
        $this->refresh();
        return true;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_active_at' => 'datetime',
        'attendance_percentage' => 'decimal:2',
    ];
}
