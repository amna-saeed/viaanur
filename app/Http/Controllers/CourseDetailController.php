<?php

namespace App\Http\Controllers;

use App\Support\CourseCatalog;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CourseDetailController extends Controller
{
    public function show(string $slug): View
    {
        $course = CourseCatalog::get($slug);

        if (! $course) {
            throw new NotFoundHttpException('Course not found.');
        }

        return view('pages.coursesDetail.primary', [
            'course' => $course,
        ]);
    }
}
