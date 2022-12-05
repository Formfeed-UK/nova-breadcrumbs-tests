<?php

namespace Tests\Feature\Breadcrumbs;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Formfeed\Breadcrumbs\Breadcrumb;
use Formfeed\Breadcrumbs\Breadcrumbs;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;


class BreadcrumbsStaticTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */

    protected function setUp() :void {

        parent::setUp();

        $this->actingAs(\App\Models\User::findOrFail(1));

        $breadcrumbs = new \ReflectionClass(Breadcrumbs::class);
        $detailBreadcrumbCallback = $breadcrumbs->getProperty('detailBreadcrumbCallback');
        $detailBreadcrumbCallback->setAccessible(true);
        $detailBreadcrumbCallback->setValue(null);

        $indexBreadcrumbCallback = $breadcrumbs->getProperty('indexBreadcrumbCallback');
        $indexBreadcrumbCallback->setAccessible(true);
        $indexBreadcrumbCallback->setValue(null);

        $formBreadcrumbCallback = $breadcrumbs->getProperty('formBreadcrumbCallback');
        $formBreadcrumbCallback->setAccessible(true);
        $formBreadcrumbCallback->setValue(null);

        $resourceBreadcrumbCallback = $breadcrumbs->getProperty('resourceBreadcrumbCallback');
        $resourceBreadcrumbCallback->setAccessible(true);
        $resourceBreadcrumbCallback->setValue(null);

        $dashboardBreadcrumbCallback = $breadcrumbs->getProperty('dashboardBreadcrumbCallback');
        $dashboardBreadcrumbCallback->setAccessible(true);
        $dashboardBreadcrumbCallback->setValue(null);

        $rootBreadcrumbCallback = $breadcrumbs->getProperty('rootBreadcrumbCallback');
        $rootBreadcrumbCallback->setAccessible(true);
        $rootBreadcrumbCallback->setValue(null);

        $groupBreadcrumbCallback = $breadcrumbs->getProperty('groupBreadcrumbCallback');
        $groupBreadcrumbCallback->setAccessible(true);
        $groupBreadcrumbCallback->setValue(null);

    }

    public function test_root_callback() {
        Breadcrumbs::rootCallback(function (NovaRequest $request, Breadcrumbs $breadcrumbs, Breadcrumb $breadcrumb) {
            return [
                Breadcrumb::make("Root Override"),
            ];
        });

        $response = $this->get('/nova/dashboards/main');
        $response->assertInertia(function (Assert $page) {
            $page->has('breadcrumbs', 2);
            $page->where('breadcrumbs.0.name', "Root Override");
        });
    }

    public function test_dashboard_callback() {
        Breadcrumbs::dashboardCallback(function (NovaRequest $request, Breadcrumbs $breadcrumbs, Breadcrumb $breadcrumb) {
            return [
                Breadcrumb::make("Dashboard Override"),
                $breadcrumb,
            ];
        });

        $response = $this->get('/nova/dashboards/main');
        $response->assertInertia(function (Assert $page) {
            $page->has('breadcrumbs', 3);
            $page->where('breadcrumbs.1.name', "Dashboard Override");
        });
    }

    public function test_resource_callback() {

        Breadcrumbs::resourceCallback(function (NovaRequest $request, Breadcrumbs $breadcrumbs, $breadcrumbArray) {
            return [
                Breadcrumb::make("Resource Override"),
                ...$breadcrumbArray,
                Breadcrumb::make("Resource Override 2"),
            ];
        });

        $response = $this->get('/nova/resources/level-ones/1');
        $response->assertInertia(function (Assert $page) {
            $page->has('breadcrumbs', 5);
            $page->where('breadcrumbs.1.name', "Resource Override");
            $page->where('breadcrumbs.4.name', "Resource Override 2");
        });
    }

    public function test_reseource_callback_nested() {
        Breadcrumbs::resourceCallback(function (NovaRequest $request, Breadcrumbs $breadcrumbs, $breadcrumbArray) {
            return [
                Breadcrumb::make("Resource Override"),
                ...$breadcrumbArray,
                Breadcrumb::make("Resource Override 2"),
            ];
        });

        $response = $this->get('/nova/resources/level-two-as/1');
        $response->assertInertia(function (Assert $page) {
            $page->has('breadcrumbs', 9);
            $page->where('breadcrumbs.1.name', "Resource Override");
            $page->where('breadcrumbs.4.name', "Resource Override 2");
            $page->where('breadcrumbs.5.name', "Resource Override");
            $page->where('breadcrumbs.8.name', "Resource Override 2");
        });
    }

    public function test_index_callback() {
        Breadcrumbs::indexCallback(function (NovaRequest $request, Breadcrumbs $breadcrumbs, Breadcrumb $breadcrumb) {
            return [
                Breadcrumb::make("Index Override"),
            ];
        });

        $response = $this->get('/nova/resources/level-ones');
        $response->assertInertia(function (Assert $page) {
            $page->has('breadcrumbs', 2);
            $page->where('breadcrumbs.1.name', "Index Override");
        });
    }

    public function test_detail_callback() {
        Breadcrumbs::detailCallback(function (NovaRequest $request, Breadcrumbs $breadcrumbs, Breadcrumb $breadcrumb) {
            return [
                Breadcrumb::make("Detail Override"),
            ];
        });

        $response = $this->get('/nova/resources/level-ones/1');
        $response->assertInertia(function (Assert $page) {
            $page->has('breadcrumbs', 3);
            $page->where('breadcrumbs.2.name', "Detail Override");
        });
    }

    public function test_create_callback() {
        Breadcrumbs::formCallback(function (NovaRequest $request, Breadcrumbs $breadcrumbs, Breadcrumb $breadcrumb, $type) {
            return [
                Breadcrumb::make("Form Override " . $type),
            ];
        });

        $response = $this->get('/nova/resources/level-ones/new');
        $response->assertInertia(function (Assert $page) {
            $page->has('breadcrumbs', 3);
            $page->where('breadcrumbs.2.name', "Form Override create");
        });
    }

    public function test_edit_callback() {
        Breadcrumbs::formCallback(function (NovaRequest $request, Breadcrumbs $breadcrumbs, Breadcrumb $breadcrumb, $type) {
            return [
                Breadcrumb::make("Form Override " . $type),
            ];
        });

        $response = $this->get('/nova/resources/level-ones/1/edit');
        $response->assertInertia(function (Assert $page) {
            $page->has('breadcrumbs', 4);
            $page->where('breadcrumbs.3.name', "Form Override update");
        });
    }

}
