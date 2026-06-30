<a class="admin-lms-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
    <span class="admin-lms-nav-link__icon" aria-hidden="true"><i class="bi bi-grid-1x2-fill"></i></span>
    <span class="admin-lms-nav-link__label">Dashboard</span>
    @if(!empty($pendingLeaveCount))
        <span class="admin-lms-nav-link__badge" aria-label="{{ $pendingLeaveCount }} pending leave requests">{{ $pendingLeaveCount }}</span>
    @endif
</a>
<a class="admin-lms-nav-link {{ request()->routeIs('admin.students*') ? 'active' : '' }}" href="{{ route('admin.students.index') }}">
    <span class="admin-lms-nav-link__icon" aria-hidden="true"><i class="bi bi-people-fill"></i></span>
    <span class="admin-lms-nav-link__label">Students</span>
</a>
<a class="admin-lms-nav-link {{ request()->routeIs('admin.attendance*') ? 'active' : '' }}" href="{{ route('admin.attendance.index') }}">
    <span class="admin-lms-nav-link__icon" aria-hidden="true"><i class="bi bi-calendar2-check-fill"></i></span>
    <span class="admin-lms-nav-link__label">Attendance</span>
    @if(!empty($pendingLeaveCount))
        <span class="admin-lms-nav-link__badge" aria-label="{{ $pendingLeaveCount }} pending leave requests">{{ $pendingLeaveCount }}</span>
    @endif
</a>
<a class="admin-lms-nav-link {{ request()->routeIs('admin.teachers*') ? 'active' : '' }}" href="{{ route('admin.teachers.index') }}">
    <span class="admin-lms-nav-link__icon" aria-hidden="true"><i class="bi bi-person-workspace"></i></span>
    <span class="admin-lms-nav-link__label">Teachers</span>
</a>
<a class="admin-lms-nav-link {{ request()->routeIs('admin.enrollments*') ? 'active' : '' }}" href="{{ route('admin.enrollments.index') }}">
    <span class="admin-lms-nav-link__icon" aria-hidden="true"><i class="bi bi-clipboard-check-fill"></i></span>
    <span class="admin-lms-nav-link__label">Enrollments</span>
    @if(!empty($pendingEnrollmentCount))
        <span class="admin-lms-nav-link__badge" aria-label="{{ $pendingEnrollmentCount }} pending enrollments">{{ $pendingEnrollmentCount }}</span>
    @endif
</a>
<a class="admin-lms-nav-link {{ request()->routeIs('admin.courses*') ? 'active' : '' }}" href="{{ route('admin.courses.index') }}">
    <span class="admin-lms-nav-link__icon" aria-hidden="true"><i class="bi bi-journal-bookmark-fill"></i></span>
    <span class="admin-lms-nav-link__label">Courses</span>
</a>
<span class="admin-lms-nav-section mt-2">Account</span>
<a class="admin-lms-nav-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}" href="{{ route('admin.settings.edit') }}">
    <span class="admin-lms-nav-link__icon" aria-hidden="true"><i class="bi bi-gear-fill"></i></span>
    <span class="admin-lms-nav-link__label">Admin Settings</span>
</a>
<a class="admin-lms-nav-link" href="{{ route('home') }}" target="_blank" rel="noopener noreferrer">
    <span class="admin-lms-nav-link__icon" aria-hidden="true"><i class="bi bi-box-arrow-up-right"></i></span>
    <span class="admin-lms-nav-link__label">View site</span>
</a>
