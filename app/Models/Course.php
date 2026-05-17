<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory;

    public function enrollments(): HasMany
    {
        return $this->hasMany(LmsEnrollment::class, 'course_id');
    }

    public function lmsClasses(): HasMany
    {
        return $this->hasMany(LmsClass::class, 'course_id');
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($course) {
            if (empty($course->slug)) {
                $course->slug = Str::slug($course->title);
            }
        });
        static::updating(function ($course) {
            if ($course->isDirty('title') && !$course->isDirty('slug')) {
                $course->slug = Str::slug($course->title);
            }
        });
    }
}
