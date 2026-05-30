@extends('layout.main')
@section('content')
<div class="auth-area py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow border-0 rounded-3">
                    <div class="card-body p-5">
                        <h2 class="mb-4">{{ $pageHeading }}</h2>
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif
                        @php
                            $loginAction = $loginAction ?? route('student.login');
                            $pageHeading = $pageHeading ?? 'Sign in';
                            $showRegisterLink = $showRegisterLink ?? true;
                        @endphp
                        <form method="POST" action="{{ $loginAction }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                            <div class="mb-4 form-check">
                                <input type="checkbox" name="remember" id="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                            <button type="submit" class="default-btn2 w-100">Sign in</button>
                        </form>
                        @if ($showRegisterLink)
                            <p class="mt-4 mb-0 text-center text-muted">
                                Don't have an account? <a href="{{ route('register') }}">Register</a>
                                @if (config('viaanoor.allow_web_admin_setup'))
                                    <br><span class="small">Or <a href="{{ route('setup-admin') }}">create admin account (no register)</a></span>
                                @endif
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .auth-area {
    margin: 100px 0px 0px;
}
</style>
@endsection
