<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Teacher') - ViaANur</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/fevicon.webp') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .teacher-lms-app {
            --ad-primary: #0d9488;
            --ad-primary-dark: #0f766e;
            --ad-primary-soft: #f0fdfb;
        }
        .teacher-lms-app .admin-lms-sidebar {
            background: linear-gradient(170deg, #042f2e 0%, #0f766e 45%, #0d9488 100%);
        }
        .teacher-lms-app .admin-lms-brand__badge {
            background: rgba(255,255,255,.12);
            color: #ccfbf1;
            border-color: rgba(255,255,255,.2);
        }
        .teacher-lms-app .admin-lms-nav-link.active {
            background: rgba(255,255,255,.12) !important;
            color: #ccfbf1 !important;
            border-left-color: #5eead4 !important;
        }
        .teacher-lms-app .admin-lms-avatar {
            background: linear-gradient(135deg, #0f766e, #5eead4);
        }
    </style>
    @stack('styles')
</head>
<body class="admin-lms-app teacher-lms-app">
    <a href="#teacher-main-content" class="visually-hidden-focusable admin-lms-skip">Skip to main content</a>

    <div class="admin-lms-mobilebar d-lg-none">
        <button class="admin-lms-mobilebar-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#teacherLmsNavCollapse" aria-expanded="false">
            <i class="bi bi-list" aria-hidden="true"></i>
        </button>
        <a href="{{ route('teacher.dashboard') }}" class="admin-lms-mobilebar-brand">
            <img src="{{ asset('assets/images/banner/logo-new.webp') }}" alt="ViaANur" width="110" height="30" decoding="async">
        </a>
        <span class="admin-lms-avatar admin-lms-avatar--sm">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
    </div>

    <div class="collapse admin-lms-nav-collapse d-lg-none" id="teacherLmsNavCollapse">
        <nav class="admin-lms-nav admin-lms-nav--mobile">
            @include('teacher.partials.sidebar-nav')
        </nav>
    </div>

    <aside class="admin-lms-sidebar d-none d-lg-flex flex-column">
        <div class="admin-lms-brand">
            <a href="{{ route('teacher.dashboard') }}" class="admin-lms-brand__link">
                <img src="{{ asset('assets/images/banner/logo-new.webp') }}" alt="ViaANur" width="130" height="34" decoding="async" style="filter:brightness(0) invert(1); opacity:.9;">
            </a>
            <span class="admin-lms-brand__badge">Teacher Portal</span>
        </div>
        <nav class="admin-lms-nav flex-column flex-grow-1">
            <span class="admin-lms-nav-section">Teaching</span>
            @include('teacher.partials.sidebar-nav')
        </nav>
        <div class="admin-lms-sidebar-foot">
            <a href="{{ route('teacher.settings.edit') }}" class="admin-lms-user-card text-decoration-none {{ request()->routeIs('teacher.settings*') ? 'admin-lms-user-card--active' : '' }}">
                <span class="admin-lms-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                <div class="admin-lms-user-card__meta">
                    <span class="admin-lms-user-card__name">{{ auth()->user()->name }}</span>
                    <span class="admin-lms-user-card__role">Account settings</span>
                </div>
                <i class="bi bi-chevron-right admin-lms-user-card__chevron"></i>
            </a>
        </div>
    </aside>

    <div class="admin-lms-main">
        <header class="admin-lms-topbar">
            <div class="admin-lms-topbar__lead">
                <p class="admin-lms-topbar__eyebrow mb-0">Teacher Dashboard</p>
                <h1 class="admin-lms-topbar-title mb-0">@yield('page_heading', 'Dashboard')</h1>
            </div>
            <div class="admin-lms-topbar__actions">
                <span class="admin-lms-topbar-meta d-none d-md-inline">
                    <i class="bi bi-person-workspace me-1"></i>{{ auth()->user()->name }}
                </span>
                <form action="{{ route('teacher.logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm admin-lms-btn-signout">
                        <i class="bi bi-box-arrow-right"></i>
                        <span class="d-none d-sm-inline ms-1">Sign out</span>
                    </button>
                </form>
            </div>
        </header>

        <main id="teacher-main-content" class="admin-lms-content admin-lms-fade-in">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show admin-lms-alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show admin-lms-alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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
