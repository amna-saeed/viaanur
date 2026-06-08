@extends('admin.layout')
@section('title', $student->name)
@section('page_heading', 'Student Profile')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@php
    $profile = $student->studentProfile;
@endphp

<!-- Profile Header -->
<div class="card mb-4 border-0 shadow-sm" style="background:linear-gradient(135deg, #1e293b 0%, #6f489a 100%);">
    <div class="card-body p-4 text-white">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle bg-white bg-opacity-25 p-3" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-person-circle" style="font-size: 2.5rem; color: white;"></i>
            </div>
            <div>
                <h3 class="mb-1">{{ $student->name }}</h3>
                <p class="mb-0 text-white-50"><i class="bi bi-envelope me-2"></i>{{ $student->email }}</p>
                @if($profile)
                    <p class="mb-0 text-white-50"><i class="bi bi-person-vcard me-2"></i>{{ $profile->student_id_number }}</p>
                @endif
                <p class="mb-0 text-white-50"><i class="bi bi-calendar-event me-2"></i>Joined {{ $student->created_at->format('M d, Y') }}</p>
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
                        <div class="mb-3">
                            <label class="text-muted small text-uppercase fw-bold">Student ID Number</label>
                            <p class="h6 mb-0">
                                @if($profile)
                                    {{ $profile->student_id_number }}
                                @else
                                    <span class="text-muted">Not completed</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="mb-3">
                            <label class="text-muted small text-uppercase fw-bold">Full Name</label>
                            <p class="h6 mb-0">{{ $student->name }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="mb-3">
                            <label class="text-muted small text-uppercase fw-bold">Email</label>
                            <p class="h6 mb-0">{{ $student->email }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="mb-3">
                            <label class="text-muted small text-uppercase fw-bold">Date of Birth</label>
                            <p class="h6 mb-0">
                                @if($profile && $profile->date_of_birth)
                                    <i class="bi bi-calendar-date me-2"></i>{{ $profile->date_of_birth->format('M d, Y') }}
                                @else
                                    <span class="text-muted"><i class="bi bi-dash-circle me-2"></i>Not completed</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="mb-3">
                            <label class="text-muted small text-uppercase fw-bold">Gender</label>
                            <p class="h6 mb-0">
                                @if($profile)
                                    {{ $genderOptions[$profile->gender] ?? ucfirst(str_replace('_', ' ', $profile->gender)) }}
                                @else
                                    <span class="text-muted">Not completed</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="mb-3">
                            <label class="text-muted small text-uppercase fw-bold">School Name</label>
                            <p class="h6 mb-0">
                                @if($profile && $profile->school_name)
                                    {{ $profile->school_name }}
                                @else
                                    <span class="text-muted">Not applicable</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="mb-3">
                            <label class="text-muted small text-uppercase fw-bold">Phone</label>
                            <p class="h6 mb-0">
                                @if($student->phone)
                                    <i class="bi bi-telephone me-2"></i>{{ $student->phone }}
                                @else
                                    <span class="text-muted"><i class="bi bi-dash-circle me-2"></i>Not provided</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-12 mb-4">
                        <div class="mb-3">
                            <label class="text-muted small text-uppercase fw-bold">Home Address</label>
                            <p class="h6 mb-0">
                                @if($profile)
                                    {{ $profile->home_address }}
                                @else
                                    <span class="text-muted">Not completed</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="mb-3">
                            <label class="text-muted small text-uppercase fw-bold">Member Since</label>
                            <p class="h6 mb-0"><i class="bi bi-calendar3 me-2"></i>{{ $student->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Guardian & Emergency Contact Card -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-header bg-white border-bottom p-4">
                <h5 class="mb-0"><i class="bi bi-shield-check text-danger me-2"></i>Guardian & Emergency Contacts</h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="text-muted small text-uppercase fw-bold">Parent/Guardian Name</label>
                        <p class="h6 mb-0">
                            @if($profile)
                                {{ $profile->guardian_name }}
                            @else
                                <span class="text-muted">Not completed</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="text-muted small text-uppercase fw-bold">Parent/Guardian Contact Number</label>
                        <p class="h6 mb-0">
                            @if($profile)
                                <i class="bi bi-telephone me-2"></i>{{ $profile->guardian_contact_number }}
                            @else
                                <span class="text-muted">Not completed</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="text-muted small text-uppercase fw-bold">Emergency Contact Number</label>
                        <p class="h6 mb-0">
                            @if($profile && $profile->emergency_contact_number)
                                <i class="bi bi-telephone-plus me-2"></i>{{ $profile->emergency_contact_number }}
                            @elseif($profile)
                                <span class="text-muted">Same as guardian contact</span>
                            @else
                                <span class="text-muted">Not completed</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Card -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-header bg-white border-bottom p-4">
                <h5 class="mb-0"><i class="bi bi-activity text-success me-2"></i>Activity & Attendance</h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="text-muted small text-uppercase fw-bold">Last Active</label>
                        <p class="h6 mb-0">
                            @if($student->last_active_at)
                                <i class="bi bi-clock-history me-2 text-info"></i>{{ $student->last_active_at->format('M d, Y H:i') }}
                            @else
                                <span class="text-muted"><i class="bi bi-dash-circle me-2"></i>Never active</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="text-muted small text-uppercase fw-bold">Attendance Rate</label>
                        <div class="d-flex align-items-center gap-3">
                            <div class="progress" style="width: 150px; height: 25px;">
                                <div class="progress-bar {{ $student->attendance_percentage >= 80 ? 'bg-success' : ($student->attendance_percentage >= 60 ? 'bg-warning' : 'bg-danger') }}" role="progressbar" style="width: {{ $student->attendance_percentage }}%;" aria-valuenow="{{ $student->attendance_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="badge {{ $student->attendance_percentage >= 80 ? 'bg-success' : ($student->attendance_percentage >= 60 ? 'bg-warning' : 'bg-danger') }}">{{ number_format($student->attendance_percentage, 1) }}%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enrolled Courses Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom p-4">
                <h5 class="mb-0"><i class="bi bi-book-half text-info me-2"></i>Enrolled Courses</h5>
            </div>
            <div class="card-body p-4">
                @if($student->enrolledCourses->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                        <p class="text-muted mt-3 mb-0">No courses enrolled yet</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th><i class="bi bi-book me-2"></i>Course Name</th>
                                    <th><i class="bi bi-calendar-check me-2"></i>Enrolled On</th>
                                    <th><i class="bi bi-graph-up me-2"></i>Progress</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($student->enrolledCourses as $course)
                                    @php
                                        $enrollment = $student->lmsEnrollments->where('course_id', $course->id)->first();
                                        $totalQuizzes = $course->quizzes->count();
                                        $attemptedQuizzes = $student->quizAttempts()->whereIn('quiz_id', $course->quizzes->pluck('id'))->count();
                                        $progress = $totalQuizzes > 0 ? round(($attemptedQuizzes / $totalQuizzes) * 100) : 0;
                                    @endphp
                                    <tr>
                                        <td>
                                            <strong class="text-dark">{{ $course->title }}</strong>
                                        </td>
                                        <td>
                                            @if($enrollment)
                                                <small class="text-muted">{{ $enrollment->created_at->format('M d, Y') }}</small>
                                            @else
                                                <small class="text-muted">-</small>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="progress flex-grow-1" style="height: 20px; min-width: 100px;">
                                                    @if($progress >= 75)
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                    @elseif($progress >= 50)
                                                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                    @elseif($progress > 0)
                                                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                    @else
                                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: 5%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                    @endif
                                                </div>
                                                <span class="badge {{ $progress >= 75 ? 'bg-success' : ($progress >= 50 ? 'bg-info' : ($progress > 0 ? 'bg-warning' : 'bg-secondary')) }}">{{ $progress }}%</span>
                                            </div>
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
                <div class="row g-3">
                    <div class="col-6">
                        <div class="text-center p-3 bg-light rounded">
                            <i class="bi bi-book-fill text-info" style="font-size: 1.8rem;"></i>
                            <h3 class="mt-2 mb-1">{{ $student->enrolledCourses->count() }}</h3>
                            <small class="text-muted">Courses</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center p-3 bg-light rounded">
                            <i class="bi bi-pencil-square text-success" style="font-size: 1.8rem;"></i>
                            <h3 class="mt-2 mb-1">{{ $student->quizAttempts ? $student->quizAttempts->count() : 0 }}</h3>
                            <small class="text-muted">Attempts</small>
                        </div>
                    </div>
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
                    <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-pencil me-2"></i>Edit Student
                    </a>
                    <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary btn-lg">
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
    .progress-bar {
        transition: width 0.6s ease;
    }
</style>
@endsection
