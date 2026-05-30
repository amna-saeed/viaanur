<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') - ViaANur</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/fevicon.webp') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @stack('styles')
</head>
<body class="admin-lms-app">
    <a href="#admin-main-content" class="visually-hidden-focusable admin-lms-skip">Skip to main content</a>

    <div class="admin-lms-mobilebar d-lg-none">
        <button class="admin-lms-mobilebar-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#adminLmsNavCollapse" aria-expanded="false" aria-controls="adminLmsNavCollapse">
            <i class="bi bi-list" aria-hidden="true"></i>
            <span class="visually-hidden">Open navigation menu</span>
        </button>
        <a href="{{ route('admin.dashboard') }}" class="admin-lms-mobilebar-brand">
            <img src="{{ asset('assets/images/banner/logo-new.webp') }}" alt="ViaANur" width="120" height="32" decoding="async">
        </a>
        <span class="admin-lms-avatar admin-lms-avatar--sm" aria-hidden="true">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
    </div>

    <div class="collapse admin-lms-nav-collapse d-lg-none" id="adminLmsNavCollapse">
        <nav class="admin-lms-nav admin-lms-nav--mobile" aria-label="Primary">
            @include('admin.partials.sidebar-nav')
        </nav>
        <div class="admin-lms-mobile-user">
            <span class="admin-lms-avatar" aria-hidden="true">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
            <div class="admin-lms-mobile-user__text">
                <span class="admin-lms-mobile-user__name">{{ auth()->user()->name }}</span>
                <span class="admin-lms-mobile-user__role">Administrator</span>
            </div>
        </div>
    </div>

    <aside class="admin-lms-sidebar d-none d-lg-flex flex-column" aria-label="Admin navigation">
        <div class="admin-lms-brand">
            <a href="{{ route('admin.dashboard') }}" class="admin-lms-brand__link">
                <img src="{{ asset('assets/images/banner/logo-new.webp') }}" alt="ViaANur" width="140" height="36" decoding="async">
            </a>
            <span class="admin-lms-brand__badge">Admin</span>
        </div>
        <nav class="admin-lms-nav flex-column flex-grow-1" aria-label="Primary">
            @include('admin.partials.sidebar-nav')
        </nav>
        <div class="admin-lms-sidebar-foot">
            <div class="admin-lms-user-card">
                <span class="admin-lms-avatar" aria-hidden="true">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                <div class="admin-lms-user-card__meta">
                    <span class="admin-lms-user-card__name">{{ auth()->user()->name }}</span>
                    <span class="admin-lms-user-card__role">Administrator</span>
                </div>
            </div>
        </div>
    </aside>

    <div class="admin-lms-main">
        <header class="admin-lms-topbar">
            <div class="admin-lms-topbar__lead">
                <p class="admin-lms-topbar__eyebrow mb-0">LMS control center</p>
                <h1 class="admin-lms-topbar-title">@yield('page_heading', 'Admin')</h1>
            </div>
            <div class="admin-lms-topbar__actions">
                <span class="admin-lms-topbar-meta d-none d-md-inline">
                    <i class="bi bi-person-badge" aria-hidden="true"></i> {{ auth()->user()->name }}
                </span>
                <form action="{{ route('admin.logout') }}" method="POST" class="d-inline" onsubmit="return confirm('Sign out?');">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm admin-lms-btn-signout">
                        <i class="bi bi-box-arrow-right" aria-hidden="true"></i>
                        <span class="d-none d-sm-inline">Sign out</span>
                    </button>
                </form>
            </div>
        </header>

        <main id="admin-main-content" class="admin-lms-content admin-lms-fade-in">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show admin-lms-alert" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Dismiss"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show admin-lms-alert" role="alert">
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
