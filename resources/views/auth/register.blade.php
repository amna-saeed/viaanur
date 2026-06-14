@extends('layout.main')
@section('content')

<div class="reg-wrapper py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9 col-xl-8">

                <div class="reg-card">

                    {{-- Card Header --}}
                    <div class="reg-card-header">
                        <div>
                            <h3 class="reg-title">Create Your Account</h3>
                            <p class="reg-subtitle">Join our learning platform and start your journey today.</p>
                        </div>
                        <div class="reg-header-badge">
                            <i class="ri-user-add-line me-1"></i> New Student
                        </div>
                    </div>

                    {{-- Card Body --}}
                    <div class="reg-card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger mb-4">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <input type="hidden" name="role" value="student">

                            {{-- Section 01: Account Info --}}
                            <div class="reg-section">
                                <div class="reg-section-header">
                                    <span class="reg-section-num">01</span>
                                    <span class="reg-section-title">Account Information</span>
                                </div>
                                <div class="row g-3 mt-1">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name"
                                            class="form-control reg-input"
                                            value="{{ old('name') }}"
                                            placeholder="Your full name"
                                            required autofocus>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" name="email" id="email"
                                            class="form-control reg-input"
                                            value="{{ old('email') }}"
                                            placeholder="you@example.com"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                        <input type="password" name="password" id="password"
                                            class="form-control reg-input"
                                            placeholder="Create a strong password"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="form-control reg-input"
                                            placeholder="Repeat your password"
                                            required>
                                    </div>
                                </div>
                            </div>

                            {{-- Section 02: Student Info --}}
                            <div id="studentInformationFields" class="reg-section mt-4">
                                <div class="reg-section-header">
                                    <span class="reg-section-num">02</span>
                                    <span class="reg-section-title">Student Information</span>
                                </div>
                                <div class="mt-1">
                                    @include('partials.student-information-fields', ['genderOptions' => $genderOptions, 'conditional' => !empty($allowAdminOption)])
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="reg-footer mt-4 pt-3">
                                <button type="submit" class="default-btn2 reg-submit-btn">
                                    <i class="ri-user-add-line me-2"></i> Create Account
                                </button>
                                <p class="mt-3 mb-0 text-muted small text-center">
                                    Already have an account? <a href="{{ route('login') }}" class="reg-link">Sign in here</a>
                                </p>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
.reg-wrapper {
    background: #f8f9ff;
    min-height: calc(100vh - 76px);
}
/* Card */
.reg-card {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(50, 47, 137, 0.1);
    background: #fff;
}
/* Header */
.reg-card-header {
    background: linear-gradient(110deg, #322f89 0%, #1a1860 100%);
    padding: 36px 42px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
}
.reg-title {
    font-size: 24px;
    font-weight: 700;
    color: #fff;
    margin-bottom: 4px;
}
.reg-subtitle {
    font-size: 14px;
    color: rgba(255, 255, 255, 0.68);
    margin-bottom: 0;
}
.reg-header-badge {
    background: rgba(178, 205, 52, 0.18);
    color: #b2cd34;
    border: 1px solid rgba(178, 205, 52, 0.38);
    padding: 7px 18px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    white-space: nowrap;
    display: flex;
    align-items: center;
}
/* Body */
.reg-card-body {
    padding: 40px 42px;
}
/* Section */
.reg-section-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding-bottom: 12px;
    border-bottom: 2px solid #f0f0f8;
    margin-bottom: 4px;
}
.reg-section-num {
    background: #322f89;
    color: #fff;
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 700;
    flex-shrink: 0;
}
.reg-section-title {
    font-size: 15px;
    font-weight: 600;
    color: #322f89;
}
/* Inputs */
.reg-input {
    height: 46px;
    border-color: #e4e4f0;
    border-radius: 8px !important;
    font-size: 14px;
    transition: border-color 0.25s, box-shadow 0.25s;
}
.reg-input:focus {
    border-color: #322f89;
    box-shadow: 0 0 0 3px rgba(50, 47, 137, 0.08);
}
/* Also style the student-info field inputs */
.reg-card-body .form-control,
.reg-card-body .form-select {
    border-color: #e4e4f0;
    border-radius: 8px !important;
    font-size: 14px;
    transition: border-color 0.25s, box-shadow 0.25s;
}
.reg-card-body .form-control:focus,
.reg-card-body .form-select:focus {
    border-color: #322f89;
    box-shadow: 0 0 0 3px rgba(50, 47, 137, 0.08);
}
/* Footer */
.reg-footer {
    border-top: 2px solid #f0f0f8;
    text-align: center;
}
.reg-submit-btn {
    padding: 13px 48px !important;
    font-size: 15px !important;
    border-radius: 8px !important;
    font-weight: 600 !important;
    letter-spacing: 0.3px;
}
.reg-link {
    color: #322f89;
    font-weight: 600;
    text-decoration: none;
}
.reg-link:hover { color: #b2cd34; }
/* Responsive */
@media (max-width: 768px) {
    .reg-card-header {
        padding: 28px 24px;
        flex-direction: column;
        text-align: center;
        gap: 12px;
    }
    .reg-card-body { padding: 28px 24px; }
}
@media (max-width: 480px) {
    .reg-card-header { padding: 22px 18px; }
    .reg-card-body { padding: 22px 18px; }
}
</style>

<script>
(function () {
    var role = document.getElementById('role');
    var section = document.getElementById('studentInformationFields');
    if (!section) return;
    var requiredFields = section.querySelectorAll('[data-student-required]');
    function syncStudentFields() {
        var isStudent = !role || role.value === 'student';
        section.classList.toggle('d-none', !isStudent);
        requiredFields.forEach(function (field) {
            field.required = isStudent;
            field.disabled = !isStudent;
        });
    }
    syncStudentFields();
    if (role) role.addEventListener('change', syncStudentFields);
})();
</script>

@endsection
