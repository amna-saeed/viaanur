@extends('admin.layout')
@section('title', 'Lessons - ' . $course->title)
@section('page_heading', 'Lessons for ' . $course->title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h5 mb-0">Lessons</h2>
    <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Back to Courses
    </a>
</div>

<!-- Add Lesson Form -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Add New Lesson</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.lessons.store', $course) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <label for="title" class="form-label">Lesson Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="col-md-6">
                    <label for="order" class="form-label">Order</label>
                    <input type="number" class="form-control" id="order" name="order" value="0">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="video" class="form-label">Video (YouTube Link)</label>
                    <input type="url" class="form-control" id="video" name="video" placeholder="https://youtube.com/...">
                </div>
                <div class="col-md-6">
                    <label for="video_file" class="form-label">Or Upload Video File</label>
                    <input type="file" class="form-control" id="video_file" name="video_file" accept="video/*">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="pdf_notes" class="form-label">PDF / Notes Upload</label>
                    <input type="file" class="form-control" id="pdf_notes" name="pdf_notes" accept=".pdf">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Add Lesson</button>
        </form>
    </div>
</div>

<!-- Lessons List -->
<div class="card">
    <div class="card-body p-0">
        @if($lessons->isEmpty())
            <p class="text-muted p-4 mb-0">No lessons yet. Add your first lesson above.</p>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Title</th>
                            <th>Video</th>
                            <th>PDF/Notes</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lessons as $lesson)
                        <tr>
                            <td>{{ $lesson->order }}</td>
                            <td>{{ $lesson->title }}</td>
                            <td>
                                @if($lesson->video)
                                    @if(filter_var($lesson->video, FILTER_VALIDATE_URL))
                                        <a href="{{ $lesson->video }}" target="_blank">YouTube Link</a>
                                    @else
                                        <a href="{{ asset('storage/' . $lesson->video) }}" target="_blank">Video File</a>
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($lesson->pdf_notes)
                                    <a href="{{ asset('storage/' . $lesson->pdf_notes) }}" target="_blank">Download PDF</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.lessons.destroy', $lesson) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this lesson?');">
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
        @endif
    </div>
</div>
@endsection