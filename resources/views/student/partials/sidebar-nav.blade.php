<a class="student-lms-nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}" href="{{ route('student.dashboard') }}">
    <span class="student-lms-nav-link__icon" aria-hidden="true"><i class="bi bi-grid-1x2-fill"></i></span>
    <span class="student-lms-nav-link__label">Dashboard</span>
    @if(!empty($navHighlightCount))
        <span class="student-lms-nav-link__badge" aria-label="{{ $navHighlightCount }} new updates">{{ $navHighlightCount }}</span>
    @endif
</a>
<a class="student-lms-nav-link {{ request()->routeIs('student.my-courses') ? 'active' : '' }}" href="{{ route('student.my-courses') }}">
    <span class="student-lms-nav-link__icon" aria-hidden="true"><i class="bi bi-journal-bookmark-fill"></i></span>
    <span class="student-lms-nav-link__label">My courses</span>
</a>
<a class="student-lms-nav-link {{ request()->routeIs('student.attendance') ? 'active' : '' }}" href="{{ route('student.attendance') }}">
    <span class="student-lms-nav-link__icon" aria-hidden="true"><i class="bi bi-calendar-check-fill"></i></span>
    <span class="student-lms-nav-link__label">Attendance</span>
</a>
<a class="student-lms-nav-link {{ request()->routeIs('student.progress') ? 'active' : '' }}" href="{{ route('student.progress') }}">
    <span class="student-lms-nav-link__icon" aria-hidden="true"><i class="bi bi-graph-up-arrow"></i></span>
    <span class="student-lms-nav-link__label">Progress</span>
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
