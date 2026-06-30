@extends('layout.main')
@section('content')

@php
    $loginAction = $loginAction ?? route('student.login');
    $pageHeading = $pageHeading ?? 'Sign in';
    $showRegisterLink = $showRegisterLink ?? true;
@endphp

<div class="auth-page-wrapper">
    <div class="auth-split-row">

        {{-- Left Brand Panel --}}
        <div class="auth-brand-panel">
            <div class="auth-brand-content">
                <a href="{{ url('/') }}" class="d-inline-block mb-4">
                    <img src="{{ asset('assets/images/banner/logo-new.webp') }}" alt="ViAaNoor" class="auth-logo-img">
                </a>
                <h2 class="auth-brand-heading">Welcome Back!</h2>
                <p class="auth-brand-sub">Access your learning dashboard and continue your educational journey with us.</p>
                <ul class="auth-feature-list mt-4">
                    <li><i class="ri-checkbox-circle-fill"></i> Track your course progress</li>
                    <li><i class="ri-checkbox-circle-fill"></i> Access all enrolled courses</li>
                    <li><i class="ri-checkbox-circle-fill"></i> Manage your student profile</li>
                </ul>
            </div>
            <div class="auth-brand-deco-top"></div>
            <div class="auth-brand-deco-bottom"></div>
        </div>

        {{-- Right Form Panel --}}
        <div class="auth-form-panel">
            <div class="auth-form-inner">
                <h3 class="auth-form-heading">{{ $pageHeading }}</h3>
                <p class="auth-form-sub">Enter your credentials to access your account.</p>

                @if (session('success'))
                    <div class="alert alert-success mt-3">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ $loginAction }}" class="mt-4">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="auth-input-wrap">
                            <i class="ri-mail-line auth-icon"></i>
                            <input type="email" name="email" id="email"
                                class="form-control auth-input"
                                value="{{ old('email') }}"
                                placeholder="you@example.com"
                                required autofocus>
                        </div>
                    </div>
                    @include('partials.password-field-with-toggle', [
                        'id' => 'password',
                        'name' => 'password',
                        'label' => 'Password',
                        'placeholder' => '••••••••',
                        'variant' => 'auth',
                        'autocomplete' => 'current-password',
                    ])
                    <div class="mb-4">
                        <div class="form-check">
                            <input type="checkbox" name="remember" id="remember"
                                class="form-check-input"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label text-muted" for="remember">Remember me</label>
                        </div>
                    </div>
                    <button type="submit" class="default-btn2 w-100 auth-btn">Sign In</button>
                </form>

                @if ($showRegisterLink)
                    <p class="mt-4 mb-0 text-center text-muted small">
                        Don't have an account? <a href="{{ route('register') }}" class="auth-link">Create one now</a>
                    </p>
                    <p class="mt-3 mb-0 text-center small text-muted">
                        <a href="{{ route('admin.login') }}" class="auth-link">Admin sign in</a>
                        <span class="mx-1">·</span>
                        <a href="{{ route('teacher.login') }}" class="auth-link">Teacher sign in</a>
                    </p>
                    @if (config('viaanoor.allow_web_admin_setup'))
                        <p class="mt-2 mb-0 text-center small">
                            <a href="{{ route('setup-admin') }}" class="text-muted">Create admin account</a>
                        </p>
                    @endif
                @endif
            </div>
        </div>

    </div>
</div>

<style>
.auth-page-wrapper {
    min-height: calc(100vh - 76px);
    display: flex;
    align-items: stretch;
}
.auth-split-row {
    display: flex;
    width: 100%;
    min-height: calc(100vh - 76px);
}
/* Brand Panel */
.auth-brand-panel {
    width: 42%;
    background: linear-gradient(140deg, #322f89 0%, #1a1860 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px 50px;
    position: relative;
    overflow: hidden;
}
.auth-brand-deco-top {
    position: absolute;
    top: -90px;
    right: -90px;
    width: 320px;
    height: 320px;
    border-radius: 50%;
    background: rgba(178, 205, 52, 0.12);
    pointer-events: none;
}
.auth-brand-deco-bottom {
    position: absolute;
    bottom: -70px;
    left: -70px;
    width: 260px;
    height: 260px;
    border-radius: 50%;
    background: rgba(178, 205, 52, 0.08);
    pointer-events: none;
}
.auth-brand-content {
    position: relative;
    z-index: 2;
    color: #fff;
}
.auth-logo-img {
    height: 52px;
    object-fit: contain;
    filter: brightness(0) invert(1);
}
.auth-brand-heading {
    font-size: 30px;
    font-weight: 700;
    color: #fff;
    margin: 0 0 12px;
    line-height: 1.3;
}
.auth-brand-sub {
    font-size: 15px;
    color: rgba(255, 255, 255, 0.72);
    line-height: 1.75;
    margin-bottom: 0;
}
.auth-feature-list {
    list-style: none;
    padding: 0;
    margin: 0;
}
.auth-feature-list li {
    color: rgba(255, 255, 255, 0.85);
    font-size: 14px;
    padding: 7px 0;
    display: flex;
    align-items: center;
    gap: 10px;
}
.auth-feature-list li i {
    color: #b2cd34;
    font-size: 19px;
    flex-shrink: 0;
}
/* Form Panel */
.auth-form-panel {
    flex: 1;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px 50px;
}
.auth-form-inner {
    width: 100%;
    max-width: 400px;
}
.auth-form-heading {
    font-size: 26px;
    font-weight: 700;
    color: #322f89;
    margin-bottom: 6px;
}
.auth-form-sub {
    font-size: 14px;
    color: #777;
    margin-bottom: 0;
}
/* Inputs */
.auth-input-wrap {
    position: relative;
}
.auth-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #9c9ac2;
    font-size: 17px;
    z-index: 5;
    pointer-events: none;
}
.auth-input {
    padding-left: 42px !important;
    height: 48px;
    border-color: #e4e4f0;
    border-radius: 8px !important;
    font-size: 14px;
    transition: border-color 0.25s, box-shadow 0.25s;
}
.auth-input:focus {
    border-color: #322f89;
    box-shadow: 0 0 0 3px rgba(50, 47, 137, 0.1);
}
/* Submit Button */
.auth-btn {
    padding: 13px 20px !important;
    font-size: 15px !important;
    border-radius: 8px !important;
    font-weight: 600 !important;
    letter-spacing: 0.3px;
}
.auth-link {
    color: #322f89;
    font-weight: 600;
    text-decoration: none;
}
.auth-link:hover {
    color: #b2cd34;
}
/* Responsive */
@media (max-width: 991px) {
    .auth-brand-panel { display: none; }
    .auth-form-panel { padding: 50px 30px; }
}
@media (max-width: 576px) {
    .auth-form-panel { padding: 40px 20px; }
    .auth-page-wrapper { min-height: auto; }
}
</style>

@endsection
