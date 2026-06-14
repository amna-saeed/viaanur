<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id_number',
        'date_of_birth',
        'gender',
        'school_name',
        'home_address',
        'guardian_name',
        'guardian_contact_number',
        'emergency_contact_number',
        'total_sessions_booked',
        'total_sessions_attended',
        'last_session_date',
        'next_session_date',
        'homework_completion_rate',
        'assessment_average',
        'progress_score',
        'subjects_enrolled',
        'academic_level',
        'current_working_grade',
        'target_grade',
        'learning_goals',
        'areas_for_improvement',
        'send_learning_needs',
        'eal_notes',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'last_session_date' => 'date',
        'next_session_date' => 'date',
        'homework_completion_rate' => 'decimal:2',
        'assessment_average' => 'decimal:2',
        'progress_score' => 'decimal:2',
        'total_sessions_booked' => 'integer',
        'total_sessions_attended' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
