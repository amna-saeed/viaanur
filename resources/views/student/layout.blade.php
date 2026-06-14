<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'My Dashboard') - ViaANur</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/fevicon.webp') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @stack('styles')
</head>
<body class="student-lms-app">
    <a href="#student-main-content" class="visually-hidden-focusable student-lms-skip">Skip to main content</a>

    <div class="student-lms-mobilebar d-lg-none">
        <button class="student-lms-mobilebar-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#studentLmsNavCollapse" aria-expanded="false" aria-controls="studentLmsNavCollapse">
            <i class="bi bi-list" aria-hidden="true"></i>
            <span class="visually-hidden">Open navigation menu</span>
        </button>
        <a href="{{ route('student.dashboard') }}" class="student-lms-mobilebar-brand">
            <img src="{{ asset('assets/images/banner/logo-new.webp') }}" alt="ViaANur" width="120" height="32" decoding="async">
        </a>
        <span class="student-lms-avatar student-lms-avatar--sm" aria-hidden="true">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
    </div>

    <div class="collapse student-lms-nav-collapse d-lg-none" id="studentLmsNavCollapse">
        <nav class="student-lms-nav student-lms-nav--mobile" aria-label="Primary">
            @include('student.partials.sidebar-nav')
        </nav>
        <div class="student-lms-mobile-user">
            <span class="student-lms-avatar" aria-hidden="true">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
            <div class="student-lms-mobile-user__text">
                <span class="student-lms-mobile-user__name">{{ auth()->user()->name }}</span>
                <span class="student-lms-mobile-user__email">{{ auth()->user()->email }}</span>
            </div>
        </div>
    </div>

    <aside class="student-lms-sidebar d-none d-lg-flex flex-column" aria-label="Student navigation">
        <div class="student-lms-brand">
            <a href="{{ route('student.dashboard') }}" class="student-lms-brand__link">
                <img src="{{ asset('assets/images/banner/logo-new.webp') }}" alt="ViaANur" width="140" height="36" decoding="async">
            </a>
            <span class="student-lms-brand__badge">Student</span>
        </div>
        <nav class="student-lms-nav flex-column flex-grow-1" aria-label="Primary">
            @include('student.partials.sidebar-nav')
        </nav>
        <div class="student-lms-sidebar-foot">
            <div class="student-lms-user-card">
                <span class="student-lms-avatar" aria-hidden="true">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                <div class="student-lms-user-card__meta">
                    <span class="student-lms-user-card__name">{{ auth()->user()->name }}</span>
                    <span class="student-lms-user-card__role">Student account</span>
                </div>
            </div>
        </div>
    </aside>

    <div class="student-lms-main">
        <header class="student-lms-topbar">
            <div class="student-lms-topbar__lead">
                <p class="student-lms-topbar__eyebrow mb-0">Learning portal</p>
                <h1 class="student-lms-topbar-title">@yield('page_heading', 'Dashboard')</h1>
            </div>
            <div class="student-lms-topbar__actions">
                <span class="student-lms-topbar-meta d-none d-md-inline">
                    <i class="bi bi-person-circle" aria-hidden="true"></i> {{ auth()->user()->name }}
                </span>
                <form action="{{ route('student.logout') }}" method="POST" class="d-inline" onsubmit="return confirm('Sign out?');">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm student-lms-btn-signout">
                        <i class="bi bi-box-arrow-right" aria-hidden="true"></i>
                        <span class="d-none d-sm-inline">Sign out</span>
                    </button>
                </form>
            </div>
        </header>

        <main id="student-main-content" class="student-lms-content">
            @if(session('success') && ! request()->routeIs('student.courses.quizzes.take'))
                <div class="alert alert-success alert-dismissible fade show student-lms-alert" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Dismiss"></button>
                </div>
            @endif
            @if(session('error') && ! request()->routeIs('student.courses.quizzes.take'))
                <div class="alert alert-danger alert-dismissible fade show student-lms-alert" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Dismiss"></button>
                </div>
            @endif
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    @stack('scripts')
</body>
</html>
