class LessonController extends Controller
{
    public function index($courseId)
    {
        $course = Course::findOrFail($courseId);
        $lessons = $course->lessons()->orderBy('order')->get();

        return view('admin.lessons.index', compact('course', 'lessons'));
    }

    public function store(Request $request, $courseId)
    {
        $request->validate([
            'title' => 'required'
        ]);

        Lesson::create([
            'course_id' => $courseId,
            'title' => $request->title,
            'video_url' => $request->video_url,
            'order' => $request->order
        ]);

        return back();
    }

    public function destroy($id)
    {
        Lesson::findOrFail($id)->delete();
        return back();
    }
}