@extends('student.layout')
@section('title', 'My Profile')
@section('page_heading', 'My Profile')

@section('content')
@php
    $profile = $student->studentProfile;
@endphp

<section class="student-dash-welcome mb-4" aria-labelledby="student-profile-heading">
    <div class="student-dash-welcome__inner">
        <div class="student-dash-welcome__copy">
            <p class="student-dash-welcome__eyebrow mb-2">Student information</p>
            <h2 id="student-profile-heading" class="student-dash-welcome__title">{{ $student->name }}</h2>
            <p class="student-dash-welcome__text mb-0">Review your account, guardian, and emergency contact details.</p>
        </div>
        <div class="student-dash-welcome__actions d-none d-md-flex">
            <a href="{{ route('student.dashboard') }}" class="btn btn-light btn-sm student-dash-btn-ghost">
                <i class="bi bi-grid-1x2" aria-hidden="true"></i> Dashboard
            </a>
        </div>
    </div>
</section>

@unless($profile)
    <div class="alert alert-warning border-0 student-lms-alert mb-4" role="alert">
        Your full student information has not been completed yet. Please contact the administrator to update your profile.
    </div>
@endunless

<div class="row g-4">
    <div class="col-lg-8">
        <div class="student-dash-panel h-100">
            <div class="student-dash-panel__head">
                <h3 class="student-dash-panel__title mb-0"><i class="bi bi-person-vcard" aria-hidden="true"></i> Personal Information</h3>
            </div>
            <div class="student-dash-panel__body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <span class="text-muted small text-uppercase fw-bold">Student ID Number</span>
                        <p class="h6 mb-0">{{ $profile ? $profile->student_id_number : 'Not completed' }}</p>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted small text-uppercase fw-bold">Full Name</span>
                        <p class="h6 mb-0">{{ $student->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted small text-uppercase fw-bold">Email</span>
                        <p class="h6 mb-0"><i class="bi bi-envelope me-2"></i>{{ $student->email }}</p>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted small text-uppercase fw-bold">Date of Birth</span>
                        <p class="h6 mb-0">
                            @if($profile && $profile->date_of_birth)
                                <i class="bi bi-calendar-date me-2"></i>{{ $profile->date_of_birth->format('M d, Y') }}
                            @else
                                Not completed
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted small text-uppercase fw-bold">Gender</span>
                        <p class="h6 mb-0">
                            @if($profile)
                                {{ $genderOptions[$profile->gender] ?? ucfirst(str_replace('_', ' ', $profile->gender)) }}
                            @else
                                Not completed
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted small text-uppercase fw-bold">School Name</span>
                        <p class="h6 mb-0">{{ $profile && $profile->school_name ? $profile->school_name : 'Not applicable' }}</p>
                    </div>
                    <div class="col-12">
                        <span class="text-muted small text-uppercase fw-bold">Home Address</span>
                        <p class="h6 mb-0">{{ $profile ? $profile->home_address : 'Not completed' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="student-dash-panel h-100">
            <div class="student-dash-panel__head">
                <h3 class="student-dash-panel__title mb-0"><i class="bi bi-shield-check" aria-hidden="true"></i> Guardian & Emergency</h3>
            </div>
            <div class="student-dash-panel__body">
                <div class="mb-4">
                    <span class="text-muted small text-uppercase fw-bold">Parent/Guardian Name</span>
                    <p class="h6 mb-0">{{ $profile ? $profile->guardian_name : 'Not completed' }}</p>
                </div>
                <div class="mb-4">
                    <span class="text-muted small text-uppercase fw-bold">Parent/Guardian Contact</span>
                    <p class="h6 mb-0">
                        @if($profile)
                            <i class="bi bi-telephone me-2"></i>{{ $profile->guardian_contact_number }}
                        @else
                            Not completed
                        @endif
                    </p>
                </div>
                <div>
                    <span class="text-muted small text-uppercase fw-bold">Emergency Contact</span>
                    <p class="h6 mb-0">
                        @if($profile && $profile->emergency_contact_number)
                            <i class="bi bi-telephone-plus me-2"></i>{{ $profile->emergency_contact_number }}
                        @elseif($profile)
                            Same as guardian contact
                        @else
                            Not completed
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
