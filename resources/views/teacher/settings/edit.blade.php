@extends('teacher.layout')
@section('title', 'Teacher Settings')
@section('page_heading', 'Teacher Settings')

@section('content')
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4 text-center">
                <span class="admin-lms-avatar admin-lms-avatar--lg d-inline-flex mb-3" aria-hidden="true">
                    {{ strtoupper(substr($teacherUser->name, 0, 1)) }}
                </span>
                <h2 class="h5 mb-1">{{ $teacherUser->name }}</h2>
                <p class="text-muted small mb-3">{{ $teacherUser->email }}</p>
                <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle">Teacher</span>
                @if($teacherUser->last_active_at)
                    <p class="text-muted small mt-3 mb-0">
                        Last active {{ $teacherUser->last_active_at->diffForHumans() }}
                    </p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom p-4">
                <h5 class="mb-1"><i class="bi bi-gear me-2"></i>Account settings</h5>
                <p class="text-muted small mb-0">Update your display name, login email, or password.</p>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('teacher.settings.update') }}" method="POST" novalidate>
                    @csrf
                    @method('PUT')

                    <fieldset class="mb-4">
                        <legend class="h6 text-uppercase text-muted fw-semibold mb-3" style="font-size:.72rem;letter-spacing:.06em;">Profile</legend>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Display name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required value="{{ old('name', $teacherUser->name) }}" autocomplete="name">
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Login email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required value="{{ old('email', $teacherUser->email) }}" autocomplete="email">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="mb-4">
                        <legend class="h6 text-uppercase text-muted fw-semibold mb-3" style="font-size:.72rem;letter-spacing:.06em;">Security</legend>

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current password</label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" autocomplete="current-password">
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="current_password" aria-label="Show password">
                                    <i class="bi bi-eye" aria-hidden="true"></i>
                                </button>
                            </div>
                            @error('current_password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label">New password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" autocomplete="new-password">
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password" aria-label="Show password">
                                        <i class="bi bi-eye" aria-hidden="true"></i>
                                    </button>
                                </div>
                                @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Confirm new password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password_confirmation" aria-label="Show password">
                                        <i class="bi bi-eye" aria-hidden="true"></i>
                                    </button>
                                </div>
                                @error('password_confirmation')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </fieldset>

                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1" aria-hidden="true"></i> Save changes
                        </button>
                        <a href="{{ route('teacher.dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.toggle-password').forEach(function (button) {
    button.addEventListener('click', function () {
        var input = document.getElementById(button.getAttribute('data-target'));
        if (!input) return;
        var icon = button.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    });
});
</script>
@endpush
