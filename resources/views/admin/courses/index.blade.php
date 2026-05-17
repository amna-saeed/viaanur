@extends('admin.layout')
@section('title', 'Courses')
@section('page_heading', 'Courses')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h5 mb-0">All courses</h2>
    <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Add course
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($courses->isEmpty())
            <p class="text-muted p-4 mb-0">No courses yet. <a href="{{ route('admin.courses.create') }}">Add your first course</a>.</p>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                        <tr>
                            <td>
                                @if($course->image)
                                    <img src="{{ asset('storage/' . $course->image) }}" alt="" class="admin-lms-thumb me-2" width="40" height="40" loading="lazy">
                                @endif
                                {{ $course->title }}
                            </td>
                            <td>
                                @if($course->is_published)
                                    <span class="badge bg-success">Published</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                            </td>
                            <td>{{ $course->created_at->format('M j, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <a href="{{ route('admin.lessons.index', $course) }}" class="btn btn-sm btn-outline-secondary">Lessons</a>
                                <a href="{{ route('admin.quizzes.index', $course) }}" class="btn btn-sm btn-outline-info">Quizzes</a>
                                <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this course?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($courses->hasPages())
                <div class="p-3 border-top">{{ $courses->links() }}</div>
            @endif
        @endif
    </div>
</div>
@endsection
