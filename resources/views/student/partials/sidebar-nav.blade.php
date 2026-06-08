<a class="student-lms-nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}" href="{{ route('student.dashboard') }}">
    <span class="student-lms-nav-link__icon" aria-hidden="true"><i class="bi bi-grid-1x2-fill"></i></span>
    <span class="student-lms-nav-link__label">Dashboard</span>
</a>
<a class="student-lms-nav-link {{ request()->routeIs('student.profile') ? 'active' : '' }}" href="{{ route('student.profile') }}">
    <span class="student-lms-nav-link__icon" aria-hidden="true"><i class="bi bi-person-vcard-fill"></i></span>
    <span class="student-lms-nav-link__label">My profile</span>
</a>
<a class="student-lms-nav-link {{ request()->routeIs('contact-us') ? 'active' : '' }}" href="{{ route('contact-us') }}">
    <span class="student-lms-nav-link__icon" aria-hidden="true"><i class="bi bi-life-preserver"></i></span>
    <span class="student-lms-nav-link__label">Support</span>
</a>
<a class="student-lms-nav-link" href="{{ route('home') }}" target="_blank" rel="noopener noreferrer">
    <span class="student-lms-nav-link__icon" aria-hidden="true"><i class="bi bi-box-arrow-up-right"></i></span>
    <span class="student-lms-nav-link__label">View site</span>
</a>
