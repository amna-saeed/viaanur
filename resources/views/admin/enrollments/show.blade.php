@extends('admin.layout')
@section('title', 'Enrollment - ' . $enrollment->user->name)
@section('page_heading', 'Enrollment Details')

@section('content')
<!-- Header -->
<div class="card mb-4 border-0 shadow-sm" style="background: linear-gradient(135deg, #00b4db 0%, #0083b0 100%);">
    <div class="card-body p-4 text-white">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle bg-white bg-opacity-25 p-3" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-person-check-fill" style="font-size: 2.5rem; color: white;"></i>
            </div>
            <div>
                <h3 class="mb-1">{{ $enrollment->user->name }}</h3>
                <p class="mb-0 text-white-50"><i class="bi bi-envelope me-2"></i>{{ $enrollment->user->email }}</p>
                <p class="mb-0 text-white-50"><i class="bi bi-journal-bookmark me-2"></i>{{ $enrollment->course->title }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Student Information -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-header bg-white border-bottom p-4">
                <h5 class="mb-0"><i class="bi bi-person-badge text-primary me-2"></i>Student Information</h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="text-muted small text-uppercase fw-bold">Name</label>
                        <p class="h6 mb-0">{{ $enrollment->user->name }}</p>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="text-muted small text-uppercase fw-bold">Email</label>
                        <p class="h6 mb-0"><i class="bi bi-envelope me-2"></i>{{ $enrollment->user->email }}</p>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="text-muted small text-uppercase fw-bold">Phone</label>
                        <p class="h6 mb-0">
                            @if($enrollment->user->phone)
                                <i class="bi bi-telephone me-2"></i>{{ $enrollment->user->phone }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="text-muted small text-uppercase fw-bold">Joined</label>
                        <p class="h6 mb-0">{{ $enrollment->user->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Course Information -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom p-4">
                <h5 class="mb-0"><i class="bi bi-book-fill text-success me-2"></i>Course Information</h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label class="text-muted small text-uppercase fw-bold">Course Title</label>
                        <p class="h6 mb-0">{{ $enrollment->course->title }}</p>
                    </div>
                    @if($enrollment->course->description)
                    <div class="col-md-12 mb-4">
                        <label class="text-muted small text-uppercase fw-bold">Description</label>
                        <p class="mb-0">{{ Str::limit($enrollment->course->description, 200) }}</p>
                    </div>
                    @endif
                    <div class="col-md-6 mb-4">
                        <label class="text-muted small text-uppercase fw-bold">Enrollment Date</label>
                        <p class="h6 mb-0">{{ $enrollment->created_at->format('M d, Y \a\t h:i A') }}</p>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="text-muted small text-uppercase fw-bold">Duration</label>
                        <p class="h6 mb-0">
                            @if($enrollment->course->duration_weeks)
                                {{ $enrollment->course->duration_weeks }} weeks
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Quick Stats -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-header bg-white border-bottom p-4">
                <h5 class="mb-0"><i class="bi bi-bar-chart text-warning me-2"></i>Course Progress</h5>
            </div>
            <div class="card-body p-4 text-center">
                <div class="py-3">
                    <i class="bi bi-circle-fill text-primary" style="font-size: 3rem; opacity: 0.3;"></i>
                    <h3 class="mt-3 mb-1">Active</h3>
                    <small class="text-muted">Enrollment Status</small>
                </div>
            </div>
        </div>

        <!-- Enrollment Stats -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-header bg-white border-bottom p-4">
                <h5 class="mb-0"><i class="bi bi-speedometer2 text-info me-2"></i>Enrollment Stats</h5>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Status</small>
                    <span class="badge bg-success">Active</span>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Enrollment ID</small>
                    <code class="small">{{ $enrollment->id }}</code>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom p-4">
                <h5 class="mb-0"><i class="bi bi-tools text-secondary me-2"></i>Actions</h5>
            </div>
            <div class="card-body p-4">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.students.show', $enrollment->user) }}" class="btn btn-outline-primary">
                        <i class="bi bi-person me-2"></i>View Student
                    </a>
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-info">
                        <i class="bi bi-journal-bookmark me-2"></i>View Course
                    </a>
                </div>
                <hr>
                <form action="{{ route('admin.enrollments.destroy', $enrollment) }}" method="POST" onsubmit="return confirm('Remove this student from the course?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="bi bi-trash me-2"></i>Remove Enrollment
                    </button>
                </form>
                <a href="{{ route('admin.enrollments.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                    <i class="bi bi-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        transition: all 0.3s ease;
    }
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
</style>
@endsection
