<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\LmsEnrollment;
use App\Models\Student;
use App\Support\StudentSessionPool;
use Tests\TestCase;

class StudentCourseShowTest extends TestCase
{
    public function test_enrolled_student_can_open_course_page(): void
    {
        $student = Student::query()->first();
        $course = Course::query()->find(6);
        if ($student === null || $course === null) {
            $this->markTestSkipped('Missing fixtures.');
        }

        LmsEnrollment::query()->updateOrCreate(
            ['user_id' => $student->id, 'course_id' => $course->id],
            ['status' => LmsEnrollment::STATUS_APPROVED, 'approved_at' => now()]
        );

        $token = str_repeat('a', 40);

        $response = $this->actingAs($student, 'student')
            ->withSession([
                StudentSessionPool::SESSION_KEY => [
                    $token => [
                        'user_id' => $student->id,
                        'name' => $student->name,
                        'email' => $student->email,
                    ],
                ],
            ])
            ->get("/student/s/{$token}/courses/{$course->id}");

        $response->assertStatus(200);
        $response->assertSee($course->title, false);
    }
}
