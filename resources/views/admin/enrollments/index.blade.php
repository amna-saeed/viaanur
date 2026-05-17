@extends('admin.layout')
@section('title', 'Enrollments')
@section('page_heading', 'Student Enrollments')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">All Enrollments</h5>
    <a href="{{ route('admin.enrollments.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Enroll Student
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.enrollments.index') }}" class="row g-2 mb-4">
            <div class="col-md-5">
                <input type="text" name="q" class="form-control" placeholder="Search student or course..." value="{{ request('q') }}">
            </div>
            <div class="col-md-3">
                <select name="course_id" class="form-control">
                    <option value="">All Courses</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary me-2 w-auto">
                    <i class="bi bi-search"></i> Filter
                </button>
                <a href="{{ route('admin.enrollments.index') }}" class="btn btn-outline-secondary">Clear</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th><i class="bi bi-person me-2"></i>Student</th>
                        <th><i class="bi bi-journal-bookmark me-2"></i>Course</th>
                        <th><i class="bi bi-calendar-check me-2"></i>Enrolled Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($enrollments as $enrollment)
                    <tr>
                        <td>
                            <div>
                                <strong>{{ $enrollment->user->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $enrollment->user->email }}</small>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark">{{ $enrollment->course->title }}</span>
                        </td>
                        <td>
                            <small class="text-muted">{{ $enrollment->created_at->format('M d, Y') }}</small>
                        </td>
                        <td>
                            <a href="{{ route('admin.enrollments.show', $enrollment) }}" class="btn btn-sm btn-outline-primary">View</a>
                            <form action="{{ route('admin.enrollments.destroy', $enrollment) }}" method="POST" class="d-inline" onsubmit="return confirm('Remove this enrollment?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">No enrollments found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($enrollments->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $enrollments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
