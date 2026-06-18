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

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h5 class="mb-0">All Enrollments</h5>
        @if(!empty($pendingCount))
            <small class="text-warning fw-semibold"><i class="bi bi-exclamation-circle me-1"></i>{{ $pendingCount }} pending approval</small>
        @endif
    </div>
    <a href="{{ route('admin.enrollments.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Enroll Student
    </a>
</div>

@if($pendingApplications->isNotEmpty())
<div class="card border-warning shadow-sm mb-4">
    <div class="card-header bg-warning bg-opacity-10 border-warning">
        <strong><i class="bi bi-bell-fill me-2"></i>NEW STUDENT ENROLL</strong>
        <span class="text-muted fw-normal ms-2">— {{ $pendingApplications->count() }} request(s) waiting for approval</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Phone</th>
                        <th>Requested</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingApplications as $application)
                    <tr class="table-warning">
                        <td>
                            <strong>{{ $application->name }}</strong>
                            <span class="badge bg-warning text-dark ms-1">NEW</span>
                            <br>
                            <small class="text-muted">{{ $application->email }}</small>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark">{{ $enrollmentService->courseTitleFor($application) }}</span>
                        </td>
                        <td><small class="text-muted">{{ $application->phone }}</small></td>
                        <td><small class="text-muted">{{ $application->created_at->format('M d, Y h:i A') }}</small></td>
                        <td class="text-end">
                            <form action="{{ route('admin.applications.approve', $application) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Approve</button>
                            </form>
                            <form action="{{ route('admin.applications.reject', $application) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger">Reject</button>
                            </form>
                            <a href="{{ route('admin.applications.show', $application) }}" class="btn btn-sm btn-outline-primary">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h6 class="mb-3">LMS enrollments</h6>
        <form method="GET" action="{{ route('admin.enrollments.index') }}" class="row g-2 mb-4">
            <div class="col-md-4">
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
            <div class="col-md-2">
                <select name="status" class="form-control">
                    <option value="">All statuses</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary me-2 w-auto">
                    <i class="bi bi-search"></i> Filter
                </button>
                <a href="{{ route('admin.enrollments.index') }}" class="btn btn-outline-secondary">Clear</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th><i class="bi bi-person me-2"></i>Student</th>
                        <th><i class="bi bi-journal-bookmark me-2"></i>Course</th>
                        <th><i class="bi bi-flag me-2"></i>Status</th>
                        <th><i class="bi bi-calendar-check me-2"></i>Requested</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($enrollments as $enrollment)
                    <tr class="{{ $enrollment->isPending() ? 'table-warning' : '' }}">
                        <td>
                            <div>
                                <strong>{{ $enrollment->user->name }}</strong>
                                @if($enrollment->isPending())
                                    <span class="badge bg-warning text-dark ms-1">NEW</span>
                                @endif
                                <br>
                                <small class="text-muted">{{ $enrollment->user->email }}</small>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark">{{ $enrollment->course->title }}</span>
                        </td>
                        <td>
                            @if($enrollment->status === 'pending')
                                <span class="badge bg-warning text-dark">Pending approval</span>
                            @elseif($enrollment->status === 'approved')
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-secondary">Rejected</span>
                            @endif
                        </td>
                        <td>
                            <small class="text-muted">{{ $enrollment->created_at->format('M d, Y h:i A') }}</small>
                        </td>
                        <td class="text-end">
                            @if($enrollment->isPending())
                                <form action="{{ route('admin.enrollments.approve', $enrollment) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                </form>
                                <form action="{{ route('admin.enrollments.reject', $enrollment) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Reject</button>
                                </form>
                            @endif
                            <a href="{{ route('admin.enrollments.show', $enrollment) }}" class="btn btn-sm btn-outline-primary">View</a>
                            <form action="{{ route('admin.enrollments.destroy', $enrollment) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">No LMS enrollments found.</td>
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
