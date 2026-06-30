@extends('admin.layout')
@section('title', $teacher->name)
@section('page_heading', 'Teacher Profile')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Profile Header -->
<div class="card mb-4 border-0 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="card-body p-4 text-white">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle bg-white bg-opacity-25 p-3" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-person-circle" style="font-size: 2.5rem; color: white;"></i>
            </div>
            <div>
                <h3 class="mb-1">{{ $teacher->name }}</h3>
                <p class="mb-0 text-white-50"><i class="bi bi-envelope me-2"></i>{{ $teacher->email }}</p>
                @if($teacher->department)
                    <p class="mb-0 text-white-50"><i class="bi bi-briefcase me-2"></i>{{ $teacher->department }}</p>
                @endif
                <p class="mb-0 mt-2">
                    @if($teacher->user_id)
                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Teacher dashboard login enabled</span>
                        <a href="{{ route('teacher.login') }}" class="btn btn-sm btn-light ms-2" target="_blank" rel="noopener">Open teacher login</a>
                    @else
                        <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i>No login — edit teacher and set a password</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Personal Information Card -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-header bg-white border-bottom p-4">
                <h5 class="mb-0"><i class="bi bi-person-badge text-primary me-2"></i>Personal Information</h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="text-muted small text-uppercase fw-bold">Name</label>
                        <p class="h6 mb-0">{{ $teacher->name }}</p>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="text-muted small text-uppercase fw-bold">Email</label>
                        <p class="h6 mb-0"><i class="bi bi-envelope me-2"></i>{{ $teacher->email }}</p>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="text-muted small text-uppercase fw-bold">Phone</label>
                        <p class="h6 mb-0">
                            @if($teacher->phone)
                                <i class="bi bi-telephone me-2"></i>{{ $teacher->phone }}
                            @else
                                <span class="text-muted">Not provided</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="text-muted small text-uppercase fw-bold">Department</label>
                        <p class="h6 mb-0">
                            @if($teacher->department)
                                <span class="badge bg-light text-dark">{{ $teacher->department }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="text-muted small text-uppercase fw-bold">Qualification</label>
                        <p class="h6 mb-0">
                            @if($teacher->qualification)
                                {{ $teacher->qualification }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="text-muted small text-uppercase fw-bold">Status</label>
                        <p class="h6 mb-0">
                            @if($teacher->status === 'active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </p>
                    </div>
                </div>

                @if($teacher->bio)
                    <div class="mt-4">
                        <label class="text-muted small text-uppercase fw-bold">Bio</label>
                        <p class="mb-0">{{ $teacher->bio }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Assigned Subjects Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom p-4">
                <h5 class="mb-0"><i class="bi bi-book-half text-info me-2"></i>Assigned Subjects</h5>
            </div>
            <div class="card-body p-4">
                @if($teacher->subjects->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                        <p class="text-muted mt-3 mb-0">No subjects assigned yet</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th><i class="bi bi-book me-2"></i>Subject</th>
                                    <th><i class="bi bi-mortarboard me-2"></i>Course</th>
                                    <th><i class="bi bi-hash me-2"></i>Code</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teacher->subjects as $subject)
                                <tr>
                                    <td>
                                        <strong>{{ $subject->name }}</strong>
                                    </td>
                                    <td>
                                        @if($subject->course)
                                            {{ $subject->course->title }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($subject->code)
                                            <span class="badge bg-light text-dark">{{ $subject->code }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Quick Stats Card -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-header bg-white border-bottom p-4">
                <h5 class="mb-0"><i class="bi bi-speedometer2 text-warning me-2"></i>Quick Stats</h5>
            </div>
            <div class="card-body p-4">
                <div class="text-center p-3 bg-light rounded">
                    <i class="bi bi-book-fill text-info" style="font-size: 2rem;"></i>
                    <h3 class="mt-3 mb-1">{{ $teacher->subjects->count() }}</h3>
                    <small class="text-muted">Subjects Assigned</small>
                </div>
            </div>
        </div>

        <!-- Actions Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom p-4">
                <h5 class="mb-0"><i class="bi bi-tools text-secondary me-2"></i>Actions</h5>
            </div>
            <div class="card-body p-4">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.teachers.assign-subject', $teacher) }}" class="btn btn-info btn-lg">
                        <i class="bi bi-book-half me-2"></i>Manage Subjects
                    </a>
                    <a href="{{ route('admin.teachers.edit', $teacher) }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-pencil me-2"></i>Edit Teacher
                    </a>
                    <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline-secondary btn-lg">
                        <i class="bi bi-arrow-left me-2"></i>Back to List
                    </a>
                </div>
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
