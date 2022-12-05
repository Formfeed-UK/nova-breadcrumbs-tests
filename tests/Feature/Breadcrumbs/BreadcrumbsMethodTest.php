<?php

namespace Tests\Feature\Breadcrumbs;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;
use Laravel\Nova\Nova;

class BreadcrumbsMethodTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */

    protected function setUp() :void {

        parent::setUp();

        $this->actingAs(\App\Models\User::findOrFail(1));
    }

    public function test_parent_breadcrumbs_can_be_modified() {
        $response = $this->get('/nova/resources/level-two-ds');

            $response->assertInertia(function (Assert $page) {
                $page->has('breadcrumbs', 1);
            });
    }

    public function test_resource_breadcrumbs_method_on_index() {

            $response = $this->get('/nova/resources/level-two-ds');

            $response->assertInertia(function (Assert $page) {
                $page->has('breadcrumbs', 1);
                $page->where('breadcrumbs.0.name', "Breadcrumb Addition");
            });
    }

    public function test_resource_breadcrumbs_method_overrides_on_detail() {

                $response = $this->get('/nova/resources/level-two-ds/1');

                $response->assertInertia(function (Assert $page) {
                    $page->has('breadcrumbs', 1);
                    $page->where('breadcrumbs.0.name', "Breadcrumb Addition");
                });
    }

    public function test_resource_breadcrumbs_method_overrides_on_create() {

                $response = $this->get('/nova/resources/level-two-ds/new');

                $response->assertInertia(function (Assert $page) {
                    $page->has('breadcrumbs', 1);
                    $page->where('breadcrumbs.0.name', "Breadcrumb Addition");
                });
    }

    public function test_resource_breadcrumbs_method_overrides_on_edit() {

                $response = $this->get('/nova/resources/level-two-ds/1/edit');

                $response->assertInertia(function (Assert $page) {
                    $page->has('breadcrumbs', 1);
                    $page->where('breadcrumbs.0.name', "Breadcrumb Addition");
                });
    }

    public function test_resource_method_overrides_index() {

                $response = $this->get('/nova/resources/level-two-cs');

                $response->assertInertia(function (Assert $page) {
                    $page->has('breadcrumbs', 2);
                    $page->where('breadcrumbs.1.name', "Index Override");
                });
    }

    public function test_resource_method_overrides_detail() {

                $response = $this->get('/nova/resources/level-two-cs/1');

                $response->assertInertia(function (Assert $page) {
                    $page->has('breadcrumbs', 5);
                    $page->where('breadcrumbs.3.name', "Index Override");
                    $page->where('breadcrumbs.4.name', "Detail Override");
                });
    }

    public function test_resource_method_overrides_create() {

                $response = $this->get('/nova/resources/level-two-cs/new');

                $response->assertInertia(function (Assert $page) {
                    $page->has('breadcrumbs', 3);
                    $page->where('breadcrumbs.1.name', "Index Override");
                    $page->where('breadcrumbs.2.name', "Form Override create");
                });
    }

    public function test_resource_method_overrides_create_via() {

                    $response = $this->get('/nova/resources/level-two-cs/new?viaResource=level-ones&viaResourceId=1&viaRelationship=levelTwoC&relationshipType=hasMany');

                    $response->assertInertia(function (Assert $page) {
                        $page->has('breadcrumbs', 5);
                        $page->where('breadcrumbs.3.name', "Index Override");
                        $page->where('breadcrumbs.4.name', "Form Override create");
                    });
    }

    public function test_resource_method_overrides_edit() {

                $response = $this->get('/nova/resources/level-two-cs/1/edit');

                $response->assertInertia(function (Assert $page) {
                    $page->has('breadcrumbs', 6);
                    $page->where('breadcrumbs.3.name', "Index Override");
                    $page->where('breadcrumbs.4.name', "Detail Override");
                    $page->where('breadcrumbs.5.name', "Form Override update");
                });
    }







}
