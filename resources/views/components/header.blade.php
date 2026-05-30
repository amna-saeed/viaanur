<!-- Preloader -->
<div class="preloader-area position-fixed start-0 top-0 end-0 bottom-0 text-center">
    <div class="preloader">
        <img src="assets/images/banner/logo-new.webp" alt="preloader" class="loader-logo">
        <div class="waviy fw-bold">
            <span class="position-relative d-inline-block">V</span>
            <span class="position-relative d-inline-block">I</span>
            <span class="position-relative d-inline-block special">A</span>
            <span class="position-relative d-inline-block special">a</span>
            <span class="position-relative d-inline-block">N</span>
            <span class="position-relative d-inline-block">U</span>
            <span class="position-relative d-inline-block">R</span>
        </div>

    </div>
</div>
<!-- End Preloader -->

<!-- Start Navbar Area -->
<div class="page-top-tagline">
    <div class="marquee">
        <span>Build Your Future with Smart Learning</span>
    </div>
</div>

<div class="navbar-area fixed-top">
    <div class="mobile-responsive-nav">
        <div class="container">
            <div class="mobile-responsive-menu">
                <div class="logo">
                    <a href="/">
                        <img src="{{ asset('assets/images/banner/logo-new.webp') }}" alt="logo">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="desktop-nav">
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-light">
                <a class="navbar-brand me-0" href="/">
                    <img src="{{ asset('assets/images/banner/logo-new.webp') }}" alt="logo" class="header-logo" >
                </a>
                <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                                Home
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a href="{{ route('courses') }}" class="nav-link {{ request()->routeIs('courses') ? 'active' : '' }}">
                                Courses
                            </a>
                        </li> -->
                       <li class="nav-item">
                            <a href="#courses-move" class="nav-link menu-link">
                                Courses
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('teams') }}" class="nav-link {{ request()->routeIs('teams') ? 'active' : '' }}">
                                Our Team
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('about-us') }}" class="nav-link {{ request()->routeIs('about-us') ? 'active' : '' }}">
                                About Us
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('contact-us') }}" class="nav-link {{ request()->routeIs('contact-us') ? 'active' : '' }}">
                                Contact Us
                            </a>
                        </li>
                    </ul>
                    <div class="others-option position-relative d-flex align-items-center gap-2">
                       
                       
                            <div class="option-item">
                                <a href="{{ route('login') }}" class="header-nav-btn"> <i class="bi bi-person-fill ml-2"></i>Sign in</a>
                            </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <div class="others-option-for-responsive">
        <div class="container">
            <div class="dot-menu">
                <div class="inner">
                    <div class="circle circle-one"></div>
                    <div class="circle circle-two"></div>
                    <div class="circle circle-three"></div>
                </div>
            </div>
            
            <div class="container">
                <div class="option-inner">
                    <div class="others-options justify-content-center d-flex align-items-center gap-2 flex-wrap">
                        @php
                            $adminActive = auth()->check() && auth()->user()->isAdmin();
                            $studentActive = auth()->check() && auth()->user()->isStudent();

                            if (! auth()->check()) {
                                $adminActive = auth('admin')->check();
                                $studentActive = auth('student')->check() && ! $adminActive;
                            }
                        @endphp
                        @if ($adminActive || $studentActive)
                            <div class="option-item">
                                <a href="{{ route($adminActive ? 'admin.dashboard' : 'student.dashboard') }}" class="header-nav-btn">Dashboard</a>
                            </div>
                            <div class="option-item">
                                <form action="{{ route($adminActive ? 'admin.logout' : 'student.logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="header-nav-btn header-nav-btn-outline">Sign out</button>
                                </form>
                            </div>
                        @else
                            <div class="option-item">
                                <a href="{{ route('login') }}" class="header-nav-btn">Sign in <i class="bi bi-person-fill ml-2"></i></a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Navbar Area -->

<style>
:root {
    --topbar-height: 48px;
    --navbar-height: 72px;
}

.page-top-tagline {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1045;
    background: rgb(50 47 137);
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    padding: 0.5rem 0;
}

.page-top-tagline .marquee {
    width: 100%;
    white-space: nowrap;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.page-top-tagline .marquee span {
    display: inline-block;
    font-size: 14px;
    font-weight: 600;
    color: #ffff;
    padding-left: 100%;
    animation: moveText 25s linear infinite;
    letter-spacing: 0.02em;
}

@keyframes moveText {
    0% {
        transform: translateX(0%);
    }
    100% {
        transform: translateX(-100%);
    }
}

.navbar-area.fixed-top {
    position: fixed;
    top: 33px;
    left: 0;
    right: 0;
    z-index: 1040;
    width: 100%;
    background: rgba(255, 255, 255, 0.97);
    backdrop-filter: blur(12px);
    box-shadow: 0 12px 35px rgba(15, 23, 42, 0.12);
}

.navbar-area .desktop-nav .container,
.navbar-area .others-option-for-responsive .container {
    padding-left: 1rem;
    padding-right: 1rem;
}

.navbar-area .navbar {
    min-height: var(--navbar-height);
}

.navbar-area .navbar-brand img.header-logo {
    max-height: 48px;
    width: auto;
}

.navbar-nav .nav-link.active {
    color: #322f89 !important;
    font-weight: 600;
    text-decoration: underline !important;
    text-underline-offset: 6px;
    text-decoration-thickness: 2px;
}

.navbar-nav .nav-link:hover {
    color: var(--mainColor, #b2cd34) !important;
}

.loader-logo {
    width: 290px;
}

.header-nav-btn {
    z-index: 1;
    position: relative;
    padding: 8px 16px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    color: #fff;
    background: #322f89;
    font-size: 0.95rem;
    font-weight: 500;
    font-family: var(--fontFamily);
    text-decoration: none;
    transition: all 0.3s ease-in-out;
    border: 2px solid #322f89;
    cursor: pointer;
    gap: 6px;
    white-space: nowrap;
}

.header-nav-btn:hover {
    color: #fff;
    background: #2a276e;
    border-color: #2a276e;
}

.header-nav-btn-outline {
    background: transparent;
    color: #322f89;
    border: 2px solid #322f89;
}

.header-nav-btn-outline:hover {
    background: #322f89;
    color: #fff;
}

form .header-nav-btn-outline {
    font-size: 0.9rem;
    padding: 7px 14px;
}

@media (max-width: 991px) {
    .page-top-tagline {
        padding: 0.45rem 0;
    }

    .page-top-tagline .marquee span {
        font-size: clamp(0.85rem, 2.2vw, 1.05rem);
    }

    .navbar-area .navbar {
        min-height: auto;
        padding: 0.5rem 0;
    }

    .navbar-area .navbar-brand img.header-logo {
        max-height: 42px;
    }

    .header-nav-btn {
        font-size: 0.9rem;
        padding: 7px 13px;
    }
}

@media (max-width: 767px) {
    .page-top-tagline {
        padding: 0.35rem 0;
    }

    .page-top-tagline .marquee span {
        font-size: 0.92rem;
    }

    .navbar-area .desktop-nav .container,
    .navbar-area .others-option-for-responsive .container {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }

    .navbar-area .others-option {
        flex-wrap: wrap;
        gap: 0.5rem;
    }
}

body {
    padding-top: calc(var(--topbar-height) + var(--navbar-height));
    scroll-padding-top: calc(var(--topbar-height) + var(--navbar-height));
}
</style>