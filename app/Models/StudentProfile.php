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
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
