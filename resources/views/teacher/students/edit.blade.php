@extends('teacher.layout')
@section('title', 'Edit Student - ' . $student->name)
@section('page_heading', 'Edit Student Information')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom p-4">
        <h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Edit: {{ $student->name }}</h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('teacher.students.update', $student) }}" method="POST">
            @csrf
            @method('PUT')

            <h6 class="text-uppercase text-muted fw-bold mb-3">Login Credentials</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Full Name *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required value="{{ old('name', $student->name) }}">
                    @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email Address *</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required value="{{ old('email', $student->email) }}">
                    @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="col-md-6">
                    <label for="phone" class="form-label">Phone Number (Optional)</label>
                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $student->phone) }}">
                    @error('phone')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <label for="password" class="form-label">New Password (leave blank to keep current)</label>
                    <div class="input-group">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <small class="text-muted">Minimum 8 characters</small>
                    @error('password')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                </div>
                <div class="col-md-6">
                    <label for="password" class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation">
                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password_confirmation">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password_confirmation')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                </div>
            </div>

            <h6 class="text-uppercase text-muted fw-bold mt-4 mb-3">Student Information</h6>
            @include('partials.student-information-fields', ['profile' => $student->studentProfile, 'genderOptions' => $genderOptions])

            <div class="mt-4">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-check-circle me-2"></i>Save Changes
                </button>
                <a href="{{ route('teacher.students.show', $student) }}" class="btn btn-outline-secondary btn-lg">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    });
</script>
@endsection
