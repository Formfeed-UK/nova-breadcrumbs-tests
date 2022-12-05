<?php

namespace App\Nova\Dashboards;

use Formfeed\Breadcrumbs\Breadcrumb;
use Formfeed\Breadcrumbs\Breadcrumbs;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Dashboards\Main as Dashboard;
use Laravel\Nova\Http\Requests\NovaRequest;

class BreadcrumbMethod extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            new Help,
        ];
    }

    public function dashboardBreadcrumb(NovaRequest $request, BreadCrumbs $breadcrumbs, Breadcrumb $breadcrumb) {
        $breadcrumbs->items[] = Breadcrumb::make(__("Dashboard Test"), null);
        return Breadcrumb::make(__("Override Test"), null);
    }
}
