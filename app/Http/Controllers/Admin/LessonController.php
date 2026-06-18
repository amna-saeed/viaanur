<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    public function index(Course $course)
    {
        $lessons = $course->lessons()->orderBy('order')->get();
        return view('admin.courses.lessons.index', compact('course', 'lessons'));
    }

    public function store(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'video' => 'nullable|string|max:2048',
            'video_file' => 'nullable|file|mimes:mp4,avi,mov,wmv|max:102400',
            'pdf_notes' => 'nullable|file|mimes:pdf|max:51200',
            'order' => 'nullable|integer|min:0',
        ]);

        $videoPath = null;
        if ($request->hasFile('video_file')) {
            $videoPath = $request->file('video_file')->store('lessons/videos', 'public');
        } elseif ($request->video) {
            $videoPath = $request->video; // YouTube link
        }

        $pdfPath = null;
        if ($request->hasFile('pdf_notes')) {
            $pdfPath = $request->file('pdf_notes')->store('lessons/pdfs', 'public');
        }

        $course->lessons()->create([
            'title' => $request->title,
            'video' => $videoPath,
            'pdf_notes' => $pdfPath,
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('admin.lessons.index', $course)->with('success', 'Lesson created successfully.');
    }

    public function destroy(Lesson $lesson)
    {
        // Delete files if they exist
        if ($lesson->video && !filter_var($lesson->video, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($lesson->video);
        }
        if ($lesson->pdf_notes) {
            Storage::disk('public')->delete($lesson->pdf_notes);
        }

        $lesson->delete();

        return redirect()->back()->with('success', 'Lesson deleted successfully.');
    }
}