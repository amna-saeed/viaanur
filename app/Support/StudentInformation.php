<?php

namespace App\Support;

use Illuminate\Validation\Rule;

class StudentInformation
{
    public const GENDER_OPTIONS = [
        'male' => 'Male',
        'female' => 'Female',
        'other' => 'Other',
    ];

    public const STUDENT_ID_NUMBER_RULE = 'digits:13';

    public static function validationMessages(): array
    {
        return [
            'student_id_number.digits' => 'The ID card number must be exactly 13 digits.',
        ];
    }

    public static function profileRules(?int $ignoreProfileId = null): array
    {
        $studentIdRule = Rule::unique('student_profiles', 'student_id_number');

        if ($ignoreProfileId !== null) {
            $studentIdRule->ignore($ignoreProfileId);
        }

        return [
            'student_id_number' => ['required', self::STUDENT_ID_NUMBER_RULE, $studentIdRule],
            'date_of_birth' => ['required', 'date', 'before_or_equal:today'],
            'gender' => ['required', Rule::in(array_keys(self::GENDER_OPTIONS))],
            'school_name' => ['nullable', 'string', 'max:255'],
            'home_address' => ['required', 'string', 'max:1000'],
            'guardian_name' => ['required', 'string', 'max:255'],
            'guardian_contact_number' => ['required', 'string', 'max:50'],
            'emergency_contact_number' => ['nullable', 'string', 'max:50'],
        ];
    }

    public static function applicationRules(): array
    {
        return [
            'student_id_number' => ['required', self::STUDENT_ID_NUMBER_RULE],
            'date_of_birth' => ['required', 'date', 'before_or_equal:today'],
            'gender' => ['required', Rule::in(array_keys(self::GENDER_OPTIONS))],
            'school_name' => ['nullable', 'string', 'max:255'],
            'home_address' => ['required', 'string', 'max:1000'],
            'guardian_name' => ['required', 'string', 'max:255'],
            'guardian_contact_number' => ['required', 'string', 'max:50'],
            'emergency_contact_number' => ['nullable', 'string', 'max:50'],
        ];
    }

    public static function profileDataFrom(array $validated): array
    {
        return array_intersect_key($validated, array_flip([
            'student_id_number',
            'date_of_birth',
            'gender',
            'school_name',
            'home_address',
            'guardian_name',
            'guardian_contact_number',
            'emergency_contact_number',
        ]));
    }

    public static function dashboardMetricsRules(): array
    {
        return [
            'attendance_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'total_sessions_booked' => ['nullable', 'integer', 'min:0'],
            'total_sessions_attended' => ['nullable', 'integer', 'min:0'],
            'last_session_date' => ['nullable', 'date'],
            'next_session_date' => ['nullable', 'date'],
            'homework_completion_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'assessment_average' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'progress_score' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ];
    }

    public static function academicInfoRules(): array
    {
        return [
            'subjects_enrolled' => ['nullable', 'string', 'max:2000'],
            'academic_level' => ['nullable', 'string', 'max:255'],
            'current_working_grade' => ['nullable', 'string', 'max:255'],
            'target_grade' => ['nullable', 'string', 'max:255'],
            'learning_goals' => ['nullable', 'string', 'max:2000'],
            'areas_for_improvement' => ['nullable', 'string', 'max:2000'],
            'send_learning_needs' => ['nullable', 'string', 'max:2000'],
            'eal_notes' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public static function dashboardMetricsFrom(array $validated): array
    {
        return array_intersect_key($validated, array_flip([
            'total_sessions_booked',
            'total_sessions_attended',
            'last_session_date',
            'next_session_date',
            'homework_completion_rate',
            'assessment_average',
            'progress_score',
        ]));
    }

    public static function academicInfoFrom(array $validated): array
    {
        return array_intersect_key($validated, array_flip([
            'subjects_enrolled',
            'academic_level',
            'current_working_grade',
            'target_grade',
            'learning_goals',
            'areas_for_improvement',
            'send_learning_needs',
            'eal_notes',
        ]));
    }
}
