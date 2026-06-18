@extends('admin.layout')
@section('title', 'Enrollment Request · ' . $application->name)
@section('page_heading', 'Enrollment Request')

@section('content')
<div class="enr-hero mb-4">
  <div class="enr-hero__avatar" aria-hidden="true">{{ strtoupper(substr($application->name, 0, 1)) }}</div>
  <div class="enr-hero__body">
    <p class="enr-hero__eyebrow mb-1">Apply form request</p>
    <h2 class="enr-hero__name">{{ $application->name }}</h2>
    <div class="enr-hero__meta">
      <span><i class="bi bi-envelope me-1"></i>{{ $application->email }}</span>
      <span class="mx-2">·</span>
      <span><i class="bi bi-journal-bookmark me-1"></i>{{ $courseTitle }}</span>
    </div>
  </div>
  @if($application->isPendingReview())
    <div class="enr-hero__actions ms-auto d-flex gap-2 flex-wrap">
      <form action="{{ route('admin.applications.approve', $application) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success"><i class="bi bi-check-circle me-1"></i>Approve</button>
      </form>
      <form action="{{ route('admin.applications.reject', $application) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-outline-danger"><i class="bi bi-x-circle me-1"></i>Reject</button>
      </form>
    </div>
  @endif
</div>

<div class="row g-4">
  <div class="col-lg-8">
    <div class="ad-panel">
      <div class="ad-panel__head">
        <h3 class="ad-panel__title">Applicant details</h3>
      </div>
      <div class="ad-panel__body">
        <div class="row g-3">
          <div class="col-md-6"><strong>Name:</strong> {{ $application->name }}</div>
          <div class="col-md-6"><strong>Email:</strong> {{ $application->email }}</div>
          <div class="col-md-6"><strong>Phone:</strong> {{ $application->phone }}</div>
          <div class="col-md-6"><strong>Course:</strong> {{ $courseTitle }}</div>
          <div class="col-md-6"><strong>ID Card:</strong> {{ $application->student_id_number }}</div>
          <div class="col-md-6"><strong>Date of birth:</strong> {{ optional($application->date_of_birth)->format('M d, Y') }}</div>
          <div class="col-md-6"><strong>Gender:</strong> {{ \App\Support\StudentInformation::GENDER_OPTIONS[$application->gender] ?? $application->gender }}</div>
          <div class="col-md-6"><strong>School:</strong> {{ $application->school_name ?: '—' }}</div>
          <div class="col-12"><strong>Home address:</strong> {{ $application->home_address }}</div>
          <div class="col-md-6"><strong>Guardian:</strong> {{ $application->guardian_name }}</div>
          <div class="col-md-6"><strong>Guardian contact:</strong> {{ $application->guardian_contact_number }}</div>
          <div class="col-md-6"><strong>Emergency contact:</strong> {{ $application->emergency_contact_number ?: '—' }}</div>
          <div class="col-md-6"><strong>Submitted:</strong> {{ $application->created_at->format('M d, Y h:i A') }}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="ad-panel">
      <div class="ad-panel__head"><h3 class="ad-panel__title">Status</h3></div>
      <div class="ad-panel__body">
        @if($application->isPendingReview())
          <span class="badge bg-warning text-dark">Pending approval</span>
          <p class="small text-muted mt-3 mb-0">Approving will create a student account (if needed) and grant LMS course access.</p>
        @elseif($application->status === 'approved')
          <span class="badge bg-success">Approved</span>
        @else
          <span class="badge bg-secondary">Rejected</span>
        @endif
        <a href="{{ route('admin.enrollments.index') }}" class="btn btn-link w-100 mt-3">Back to enrollments</a>
      </div>
    </div>
  </div>
</div>
@endsection
