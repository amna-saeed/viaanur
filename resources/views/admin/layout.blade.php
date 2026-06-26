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
    <style>
        /* ── Brand colour overrides ── */
        .admin-lms-app {
            --ad-primary:       #322f89;
            --ad-primary-dark:  #1a1860;
            --ad-primary-soft:  #eeedf8;
            --ad-accent:        #b2cd34;
            --ad-accent-soft:   rgba(178,205,52,.15);
            --ad-sidebar-w:     268px;
            --ad-topbar-h:      64px;
            --ad-radius:        14px;
            --ad-radius-sm:     10px;
            --ad-shadow:        0 1px 3px rgba(15,23,42,.04), 0 6px 20px rgba(15,23,42,.06);
            --ad-shadow-hover:  0 4px 8px rgba(15,23,42,.06), 0 16px 36px rgba(15,23,42,.1);
            --ad-surface:       #ffffff;
            --ad-bg:            #f4f5fb;
            --ad-border:        #e4e4f0;
            --ad-text:          #0f172a;
            --ad-muted:         #64748b;
        }

        /* ── Sidebar ── */
        .admin-lms-sidebar {
            background: linear-gradient(170deg, #0e0d2e 0%, #1a1860 45%, #322f89 100%);
        }
        .admin-lms-brand {
            padding: 1.4rem 1.3rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,.07);
        }
        .admin-lms-brand__badge {
            background: var(--ad-accent-soft);
            color: var(--ad-accent);
            border: 1px solid rgba(178,205,52,.3);
            font-size: .66rem;
            letter-spacing: .07em;
            padding: .2rem .6rem;
            border-radius: 999px;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: .6rem;
            display: inline-block;
        }

        /* nav items */
        .admin-lms-nav {
            padding: .85rem .7rem;
        }
        .admin-lms-nav-link {
            border-left: 3px solid transparent;
            border-radius: 0 var(--ad-radius-sm) var(--ad-radius-sm) 0;
            padding: .68rem .85rem;
            gap: .7rem;
            font-size: .875rem;
        }
        .admin-lms-nav-link.active {
            background: var(--ad-accent-soft) !important;
            color: #b2cd34 !important;
            border-left-color: #b2cd34 !important;
        }
        .admin-lms-nav-link.active .admin-lms-nav-link__icon {
            background: rgba(178,205,52,.22) !important;
            color: #b2cd34 !important;
        }
        .admin-lms-nav-link:hover,
        .admin-lms-nav-link:focus-visible {
            background: rgba(255,255,255,.07) !important;
            color: #fff !important;
        }
        .admin-lms-nav-link__badge {
            margin-left: auto;
            min-width: 1.35rem;
            height: 1.35rem;
            padding: 0 .4rem;
            border-radius: 999px;
            background: #e11d48;
            color: #fff;
            font-size: .68rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }

        /* section label inside sidebar */
        .admin-lms-nav-section {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: rgba(255,255,255,.3);
            padding: 1rem .85rem .35rem;
        }

        /* sidebar foot */
        .admin-lms-sidebar-foot {
            padding: .9rem;
            border-top: 1px solid rgba(255,255,255,.07);
        }
        .admin-lms-user-card {
            background: rgba(255,255,255,.07);
            border-radius: var(--ad-radius-sm);
        }

        /* avatar */
        .admin-lms-avatar {
            background: linear-gradient(135deg, #322f89, #b2cd34);
        }

        /* ── Topbar ── */
        .admin-lms-topbar {
            background: rgba(255,255,255,.95);
            border-bottom: 1px solid var(--ad-border);
        }
        .admin-lms-topbar__eyebrow {
            color: var(--ad-primary);
            font-size: .68rem;
        }
        .admin-lms-topbar-title {
            font-size: 1.3rem;
            color: var(--ad-text);
        }
        .admin-lms-topbar-meta {
            background: var(--ad-primary-soft);
            color: var(--ad-primary);
            padding: .3rem .75rem;
            border-radius: 999px;
            font-size: .8rem;
            font-weight: 600;
        }
        .admin-lms-btn-signout {
            border-radius: 9px;
            font-size: .8rem;
        }

        /* ── Enrollment notification (top-right) ── */
        .admin-enrollment-notify {
            position: relative;
        }
        .admin-enrollment-notify__btn {
            position: relative;
            width: 40px;
            height: 40px;
            border: 1px solid var(--ad-border);
            border-radius: 10px;
            background: #fff;
            color: var(--ad-primary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background .2s, box-shadow .2s;
            box-shadow: var(--ad-shadow);
        }
        .admin-enrollment-notify__btn:hover {
            background: var(--ad-primary-soft);
            box-shadow: var(--ad-shadow-hover);
        }
        .admin-enrollment-notify__badge {
            position: absolute;
            top: -5px;
            right: -5px;
            min-width: 1.1rem;
            height: 1.1rem;
            padding: 0 .3rem;
            border-radius: 999px;
            background: #e11d48;
            color: #fff;
            font-size: .62rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
            border: 2px solid #fff;
        }
        .admin-enrollment-toasts {
            position: fixed;
            top: 78px;
            right: 1.25rem;
            z-index: 1080;
            display: flex;
            flex-direction: column;
            gap: .65rem;
            max-width: 340px;
            width: calc(100vw - 2.5rem);
            pointer-events: none;
        }
        .admin-enrollment-toast {
            pointer-events: auto;
            border: 1px solid rgba(178,205,52,.5);
            border-left: 4px solid #b2cd34;
            border-radius: 12px;
            background: linear-gradient(135deg, #fafbe8 0%, #fff 100%);
            padding: .85rem 1rem;
            box-shadow: 0 8px 24px rgba(50,47,137,.14);
            animation: adminEnrollmentToastIn .35s ease;
        }
        .admin-enrollment-toast.is-closing {
            opacity: 0;
            transform: translateX(12px);
            transition: opacity .3s ease, transform .3s ease;
        }
        .admin-enrollment-toast__label {
            font-size: .68rem;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #6b8c00;
            margin-bottom: .2rem;
        }
        .admin-enrollment-toast__title {
            font-size: .95rem;
            font-weight: 800;
            color: #1a1860;
            margin: 0 0 .25rem;
        }
        .admin-enrollment-toast__text {
            font-size: .8rem;
            color: #475569;
            margin: 0 0 .65rem;
        }
        .admin-enrollment-toast__actions {
            display: flex;
            gap: .45rem;
            flex-wrap: wrap;
        }
        .admin-enrollment-toast__actions .btn {
            font-size: .72rem;
            padding: .25rem .65rem;
        }
        @keyframes adminEnrollmentToastIn {
            from { opacity: 0; transform: translateX(16px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @media (max-width: 991px) {
            .admin-enrollment-toasts { top: 68px; }
        }

        /* ── Main content area ── */
        .admin-lms-content {
            background: var(--ad-bg);
        }

        /* ── Buttons ── */
        .admin-lms-btn-primary {
            background: #fff !important;
            color: var(--ad-primary) !important;
            border-color: var(--ad-border) !important;
            font-weight: 600;
            font-size: .8rem;
            border-radius: 9px;
            box-shadow: var(--ad-shadow);
        }
        .admin-lms-btn-primary:hover {
            background: var(--ad-primary-soft) !important;
            box-shadow: var(--ad-shadow-hover);
        }
        .admin-lms-btn-outline {
            --bs-btn-color:        #322f89;
            --bs-btn-border-color: #c5c4e8;
            --bs-btn-hover-bg:     #eeedf8;
            --bs-btn-hover-border-color: #9c9ac2;
            --bs-btn-hover-color:  #1a1860;
            font-size: .78rem;
            border-radius: 8px;
        }

        /* ── Bootstrap overrides ── */
        .admin-lms-app .btn-primary {
            --bs-btn-bg:           #322f89;
            --bs-btn-border-color: #322f89;
            --bs-btn-hover-bg:     #1a1860;
            --bs-btn-hover-border-color: #1a1860;
        }
        .admin-lms-app .form-control:focus,
        .admin-lms-app .form-select:focus {
            border-color: #9c9ac2;
            box-shadow: 0 0 0 3px rgba(50,47,137,.12);
        }
        .admin-lms-app .pagination {
            margin-bottom: 0;
            flex-wrap: wrap;
            gap: .25rem;
        }
        .admin-lms-app .pagination .page-link {
            color: #322f89;
            border-radius: 8px;
            min-width: 38px;
            text-align: center;
        }
        .admin-lms-app .pagination .page-item.disabled .page-link {
            color: #94a3b8;
            background: #f8fafc;
        }
        .admin-lms-app .pagination .page-item.active .page-link {
            background: #322f89;
            border-color: #322f89;
            color: #fff;
        }
        .admin-lms-app .pagination .page-link:hover {
            color: #1a1860;
            background: #eeedf8;
        }
        .admin-lms-badge--role {
            background: #eeedf8;
            color: #322f89;
            border: 1px solid #d1d0f0;
        }

        /* ── Mobile bar ── */
        .admin-lms-mobilebar {
            background: #fff;
            border-bottom: 2px solid var(--ad-border);
        }
        .admin-lms-mobilebar-toggle {
            background: var(--ad-primary-soft);
            color: var(--ad-primary);
        }
        .admin-lms-mobilebar-toggle:hover {
            background: #dddcf4;
            color: var(--ad-primary-dark);
        }
    </style>
    @stack('styles')
</head>
<body class="admin-lms-app">
    <a href="#admin-main-content" class="visually-hidden-focusable admin-lms-skip">Skip to main content</a>

    {{-- Mobile top bar --}}
    <div class="admin-lms-mobilebar d-lg-none">
        <button class="admin-lms-mobilebar-toggle" type="button"
            data-bs-toggle="collapse" data-bs-target="#adminLmsNavCollapse"
            aria-expanded="false" aria-controls="adminLmsNavCollapse">
            <i class="bi bi-list" aria-hidden="true"></i>
            <span class="visually-hidden">Open menu</span>
        </button>
        <a href="{{ route('admin.dashboard') }}" class="admin-lms-mobilebar-brand">
            <img src="{{ asset('assets/images/banner/logo-new.webp') }}" alt="ViaANur" width="110" height="30" decoding="async" style="filter:brightness(.1) invert(1) sepia(1) saturate(5) hue-rotate(210deg); opacity:.85;">
        </a>
        <span class="admin-lms-avatar admin-lms-avatar--sm" aria-hidden="true">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </span>
    </div>

    {{-- Mobile nav collapse --}}
    <div class="collapse admin-lms-nav-collapse d-lg-none" id="adminLmsNavCollapse">
        <nav class="admin-lms-nav admin-lms-nav--mobile" aria-label="Primary navigation">
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

    {{-- Desktop sidebar --}}
    <aside class="admin-lms-sidebar d-none d-lg-flex flex-column" aria-label="Admin navigation">
        <div class="admin-lms-brand">
            <a href="{{ route('admin.dashboard') }}" class="admin-lms-brand__link">
                <img src="{{ asset('assets/images/banner/logo-new.webp') }}" alt="ViaANur"
                    width="130" height="34" decoding="async"
                    style="filter:brightness(0) invert(1); opacity:.9;">
            </a>
            <span class="admin-lms-brand__badge">Admin Panel</span>
        </div>

        <nav class="admin-lms-nav flex-column flex-grow-1" aria-label="Primary navigation">
            <span class="admin-lms-nav-section">Main</span>
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

    {{-- Main --}}
    <div class="admin-lms-main">
        <header class="admin-lms-topbar">
            <div class="admin-lms-topbar__lead">
                <p class="admin-lms-topbar__eyebrow mb-0">LMS Control Center</p>
                <h1 class="admin-lms-topbar-title mb-0">@yield('page_heading', 'Admin')</h1>
            </div>
            <div class="admin-lms-topbar__actions">
                <div class="admin-enrollment-notify" id="admin-enrollment-notify">
                    <button type="button" class="admin-enrollment-notify__btn" id="admin-enrollment-notify-btn" aria-label="Enrollment notifications" title="Enrollment notifications">
                        <i class="bi bi-bell-fill" aria-hidden="true"></i>
                        @if(!empty($pendingEnrollmentCount))
                            <span class="admin-enrollment-notify__badge" id="admin-enrollment-notify-badge">{{ $pendingEnrollmentCount }}</span>
                        @endif
                    </button>
                </div>
                <span class="admin-lms-topbar-meta d-none d-md-inline">
                    <i class="bi bi-person-badge me-1" aria-hidden="true"></i>{{ auth()->user()->name }}
                </span>
                <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm admin-lms-btn-signout">
                        <i class="bi bi-box-arrow-right" aria-hidden="true"></i>
                        <span class="d-none d-sm-inline ms-1">Sign out</span>
                    </button>
                </form>
            </div>
        </header>

        <main id="admin-main-content" class="admin-lms-content admin-lms-fade-in">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show admin-lms-alert" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Dismiss"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show admin-lms-alert" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Dismiss"></button>
                </div>
            @endif
            @yield('content')
        </main>
    </div>

    <div id="admin-enrollment-toasts" class="admin-enrollment-toasts" aria-live="polite" aria-atomic="false"></div>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    @if(!empty($enrollmentAlertsApiUrl))
    <script>
    (function () {
        const alertsUrl = @json($enrollmentAlertsApiUrl);
        const container = document.getElementById('admin-enrollment-toasts');
        const badge = document.getElementById('admin-enrollment-notify-badge');
        const notifyBtn = document.getElementById('admin-enrollment-notify-btn');
        if (!alertsUrl || !container) return;

        const renderedIds = new Set();
        const escapeHtml = (value) => String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/"/g, '&quot;');

        const updateBadge = (count) => {
            if (!notifyBtn) return;
            let el = badge;
            if (count > 0) {
                if (!el) {
                    el = document.createElement('span');
                    el.className = 'admin-enrollment-notify__badge';
                    el.id = 'admin-enrollment-notify-badge';
                    notifyBtn.appendChild(el);
                }
                el.textContent = count;
            } else if (el) {
                el.remove();
            }
        };

        const removeToast = (id) => {
            const el = container.querySelector('[data-enrollment-alert-id="' + id + '"]');
            if (!el) return;
            el.classList.add('is-closing');
            setTimeout(() => el.remove(), 300);
        };

        const renderAlert = (alert) => {
            if (!alert || renderedIds.has(alert.id)) return;
            renderedIds.add(alert.id);

            const el = document.createElement('div');
            el.className = 'admin-enrollment-toast';
            el.setAttribute('data-enrollment-alert-id', alert.id);
            el.innerHTML =
                '<p class="admin-enrollment-toast__label">Announcement</p>' +
                '<h3 class="admin-enrollment-toast__title">NEW STUDENT ENROLL</h3>' +
                '<p class="admin-enrollment-toast__text"><strong>' + escapeHtml(alert.student_name) + '</strong> requested enrollment in <strong>' + escapeHtml(alert.course_title) + '</strong>.</p>' +
                '<div class="admin-enrollment-toast__actions">' +
                    '<a href="' + escapeHtml(alert.url) + '" class="btn btn-primary btn-sm">Review</a>' +
                    '<a href="{{ route('admin.enrollments.index') }}" class="btn btn-outline-secondary btn-sm">All enrollments</a>' +
                    '<button type="button" class="btn btn-link btn-sm text-muted ms-auto" data-dismiss-enrollment-alert="' + alert.id + '">Dismiss</button>' +
                '</div>';
            container.appendChild(el);
        };

        container.addEventListener('click', (e) => {
            const dismissId = e.target.closest('[data-dismiss-enrollment-alert]')?.getAttribute('data-dismiss-enrollment-alert');
            if (dismissId) {
                e.preventDefault();
                removeToast(dismissId);
            }
        });

        const poll = async () => {
            try {
                const res = await fetch(alertsUrl, { credentials: 'same-origin', headers: { Accept: 'application/json' } });
                if (!res.ok) return;
                const data = await res.json();
                updateBadge(data.pending_count || 0);
                (data.alerts || []).forEach(renderAlert);
            } catch (e) {
                console.error(e);
            }
        };

        poll();
        setInterval(poll, 30000);
    })();
    </script>
    @endif
    @stack('scripts')
</body>
</html>
