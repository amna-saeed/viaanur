@extends('admin.layout')
@section('title', 'Lessons - ' . $course->title)
@section('page_heading', 'Lessons for ' . $course->title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="h5 mb-0">Lessons</h2>
        <p class="text-muted small mb-0">{{ $lessons->count() }} lesson(s) in this course</p>
    </div>
    <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Back to Courses
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Could not save lesson:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card mb-4 border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">Add New Lesson</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.lessons.store', $course) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="title" class="form-label">Lesson Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="order" class="form-label">Order</label>
                    <input type="number" class="form-control @error('order') is-invalid @enderror" id="order" name="order" value="{{ old('order', 0) }}" min="0">
                    @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="video" class="form-label">Video (YouTube Link)</label>
                    <input type="url" class="form-control @error('video') is-invalid @enderror" id="video" name="video" value="{{ old('video') }}" placeholder="https://youtube.com/watch?v=...">
                    @error('video')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="video_file" class="form-label">Or Upload Video File</label>
                    <input type="file" class="form-control @error('video_file') is-invalid @enderror" id="video_file" name="video_file" accept="video/*">
                    @error('video_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="pdf_notes" class="form-label">PDF / Notes Upload</label>
                    <input type="file" class="form-control @error('pdf_notes') is-invalid @enderror" id="pdf_notes" name="pdf_notes" accept=".pdf">
                    @error('pdf_notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">
                <i class="bi bi-plus-circle me-1"></i> Add Lesson
            </button>
        </form>
    </div>
</div>

<section aria-labelledby="lesson-cards-heading">
    <h3 id="lesson-cards-heading" class="h6 text-muted text-uppercase mb-3">Course lessons</h3>

    @if($lessons->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5 text-muted">
                <i class="bi bi-collection-play fs-1 d-block mb-3"></i>
                <p class="mb-0">No lessons yet. Add your first lesson above.</p>
            </div>
        </div>
    @else
        <div class="row g-3">
            @foreach($lessons as $lesson)
                <div class="col-md-6 col-xl-4">
                    <article class="card h-100 border-0 shadow-sm admin-lesson-card">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                                <span class="badge bg-light text-dark">#{{ $lesson->order }}</span>
                                <span class="badge bg-primary-subtle text-primary">Lesson</span>
                            </div>
                            <h4 class="h6 mb-2">{{ $lesson->title }}</h4>
                            <ul class="list-unstyled small text-muted mb-3 flex-grow-1">
                                <li class="mb-1">
                                    <i class="bi bi-camera-video me-1"></i>
                                    @if($lesson->video)
                                        @if(filter_var($lesson->video, FILTER_VALIDATE_URL))
                                            <a href="{{ $lesson->video }}" target="_blank" rel="noopener">YouTube video</a>
                                        @else
                                            <a href="{{ asset('storage/' . $lesson->video) }}" target="_blank" rel="noopener">Uploaded video</a>
                                        @endif
                                    @else
                                        No video
                                    @endif
                                </li>
                                <li>
                                    <i class="bi bi-file-earmark-pdf me-1"></i>
                                    @if($lesson->pdf_notes)
                                        <a href="{{ asset('storage/' . $lesson->pdf_notes) }}" target="_blank" rel="noopener">PDF notes</a>
                                    @else
                                        No PDF
                                    @endif
                                </li>
                            </ul>
                            <form action="{{ route('admin.lessons.destroy', $lesson) }}" method="POST" class="mt-auto">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                    <i class="bi bi-trash me-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    @endif
</section>

<style>
.admin-lesson-card {
    border-radius: 14px;
    transition: transform .2s ease, box-shadow .2s ease;
}
.admin-lesson-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(50,47,137,.12) !important;
}
</style>
@endsection
