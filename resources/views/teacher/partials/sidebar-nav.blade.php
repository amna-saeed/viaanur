<a class="admin-lms-nav-link {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}" href="{{ route('teacher.dashboard') }}">
    <span class="admin-lms-nav-link__icon" aria-hidden="true"><i class="bi bi-grid-1x2-fill"></i></span>
    <span class="admin-lms-nav-link__label">Dashboard</span>
</a>
<a class="admin-lms-nav-link {{ request()->routeIs('teacher.students*') ? 'active' : '' }}" href="{{ route('teacher.students.index') }}">
    <span class="admin-lms-nav-link__icon" aria-hidden="true"><i class="bi bi-people-fill"></i></span>
    <span class="admin-lms-nav-link__label">Students</span>
</a>
<a class="admin-lms-nav-link {{ request()->routeIs('teacher.subjects*') ? 'active' : '' }}" href="{{ route('teacher.subjects.index') }}">
    <span class="admin-lms-nav-link__icon" aria-hidden="true"><i class="bi bi-book-half"></i></span>
    <span class="admin-lms-nav-link__label">My Subjects</span>
</a>
<a class="admin-lms-nav-link {{ request()->routeIs('teacher.attendance*') ? 'active' : '' }}" href="{{ route('teacher.attendance.index') }}">
    <span class="admin-lms-nav-link__icon" aria-hidden="true"><i class="bi bi-calendar2-check-fill"></i></span>
    <span class="admin-lms-nav-link__label">Attendance</span>
    @if(!empty($pendingLeaveCount))
        <span class="admin-lms-nav-link__badge" aria-label="{{ $pendingLeaveCount }} pending leave requests">{{ $pendingLeaveCount }}</span>
    @endif
</a>
<span class="admin-lms-nav-section mt-2">Account</span>
<a class="admin-lms-nav-link {{ request()->routeIs('teacher.settings*') ? 'active' : '' }}" href="{{ route('teacher.settings.edit') }}">
    <span class="admin-lms-nav-link__icon" aria-hidden="true"><i class="bi bi-gear-fill"></i></span>
    <span class="admin-lms-nav-link__label">Settings</span>
</a>
<a class="admin-lms-nav-link" href="{{ route('home') }}" target="_blank" rel="noopener noreferrer">
    <span class="admin-lms-nav-link__icon" aria-hidden="true"><i class="bi bi-box-arrow-up-right"></i></span>
    <span class="admin-lms-nav-link__label">View site</span>
</a>
