<?php

namespace App\Providers;

use App\Models\LeaveRequest;
use App\Models\LmsEnrollment;
use App\Services\EnrollmentRequestService;
use App\Services\LmsDashboardStatsService;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('student.*', function () {
            $params = student_route_params();
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
    }
}
