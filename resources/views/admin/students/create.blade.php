@extends('admin.layout')
@section('title', 'Add Student')
@section('page_heading', 'Add New Student')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom p-4">
        <h5 class="mb-0"><i class="bi bi-person-plus me-2"></i>New Student</h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.students.store') }}" method="POST">
            @csrf

            <h6 class="text-uppercase text-muted fw-bold mb-3">Login Credentials</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Full Name *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required value="{{ old('name') }}">
                    @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email Address *</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required value="{{ old('email') }}">
                    @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="col-md-6">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}">
                    @error('phone')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <label for="password" class="form-label">Password *</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                    <small class="text-muted">Minimum 8 characters</small>
                    @error('password')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                </div>
                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label">Confirm Password *</label>
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" required>
                    @error('password_confirmation')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                </div>
            </div>

            <h6 class="text-uppercase text-muted fw-bold mt-4 mb-3">Student Information</h6>
            @include('partials.student-information-fields', ['genderOptions' => $genderOptions])

            <div class="mt-4">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-plus-circle me-2"></i>Add Student
                </button>
                <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary btn-lg">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
