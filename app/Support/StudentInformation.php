<?php

namespace App\Support;

use Illuminate\Validation\Rule;

class StudentInformation
{
    public const GENDER_OPTIONS = [
        'female' => 'Female',
        'male' => 'Male',
        'other' => 'Other',
        'prefer_not_to_say' => 'Prefer not to say',
    ];

    public static function profileRules(?int $ignoreProfileId = null): array
    {
        $studentIdRule = Rule::unique('student_profiles', 'student_id_number');

        if ($ignoreProfileId !== null) {
            $studentIdRule->ignore($ignoreProfileId);
        }

        return [
            'student_id_number' => ['required', 'string', 'max:50', $studentIdRule],
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
            'student_id_number' => ['required', 'string', 'max:50'],
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
}
