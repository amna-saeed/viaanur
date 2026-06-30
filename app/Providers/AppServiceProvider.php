<?php

namespace App\Providers;

use App\Models\LeaveRequest;
use App\Models\LmsEnrollment;
use App\Services\EnrollmentRequestService;
use App\Services\LmsDashboardStatsService;
use App\Support\StudentRoute;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $helper = app_path('Helpers/student_route.php');
        if (is_file($helper)) {
            require_once $helper;
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        View::composer('student.*', function () {
            $params = StudentRoute::params();
            if ($params !== []) {
                URL::defaults($params);
            }
        });

        View::composer('student.partials.sidebar-nav', function ($view) {
            if (! Auth::guard('student')->check()) {
                return;
            }

            $lmsStats = app(LmsDashboardStatsService::class);
            $highlights = $lmsStats->studentHighlights(
                Auth::guard('student')->user(),
                $lmsStats->highlightSinceFromSession()
            );

            $view->with('navHighlightCount', $highlights['count']);
        });

        View::composer('admin.partials.sidebar-nav', function ($view) {
            if (! Auth::guard('admin')->check()) {
                return;
            }

            $enrollmentService = app(EnrollmentRequestService::class);

            $view->with('pendingLeaveCount', LeaveRequest::query()
                ->where('status', LeaveRequest::STATUS_PENDING)
                ->count());

            $view->with('pendingEnrollmentCount', $enrollmentService->pendingCount());
        });

        View::composer('admin.layout', function ($view) {
            if (! Auth::guard('admin')->check()) {
                return;
            }

            $enrollmentService = app(EnrollmentRequestService::class);

            $view->with([
                'pendingEnrollmentCount' => $enrollmentService->pendingCount(),
                'enrollmentAlertsApiUrl' => route('admin.dashboard.api.enrollment-alerts'),
            ]);
        });

        View::composer('teacher.partials.sidebar-nav', function ($view) {
            if (! Auth::guard('teacher')->check()) {
                return;
            }

            $scope = app(\App\Services\TeacherScopeService::class);
            $studentIds = $scope->studentIds();
            $pendingLeave = 0;

            if ($studentIds->isNotEmpty() && \Illuminate\Support\Facades\Schema::hasTable('leave_requests')) {
                $pendingLeave = LeaveRequest::query()
                    ->whereIn('user_id', $studentIds)
                    ->where('status', LeaveRequest::STATUS_PENDING)
                    ->count();
            }

            $view->with('pendingLeaveCount', $pendingLeave);
        });
    }
}
