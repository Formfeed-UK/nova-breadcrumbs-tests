<?php

namespace Tests\Feature\Breadcrumbs;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Formfeed\Breadcrumbs\Breadcrumb;
use Formfeed\Breadcrumbs\Breadcrumbs;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;

class BreadcrumbsParentTest extends TestCase
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

    public function test_default_parent_is_first_belongs_to_field_on_resource() {
        $response = $this->get('/nova/resources/level-three-ds/1');
        $response->assertInertia(function (Assert $page) {
            $page->has('breadcrumbs', 7);
            $page->where('breadcrumbs.3.name', "Level Two As");
            $page->where('breadcrumbs.3.path', "/resources/level-two-as");
        });
    }

    public function test_parent_method_on_model() {
        \App\Nova\LevelThreeD::$model = \App\Models\LevelThreeD2::class;

        $response = $this->get('/nova/resources/level-three-ds/1');
        $response->assertInertia(function (Assert $page) {
            $page->has('breadcrumbs', 5);
            $page->where('breadcrumbs.1.name', "Level Two Bs");
            $page->where('breadcrumbs.1.path', "/resources/level-two-bs");
        });
    }

    public function test_parent_method_on_model_with_configurable_method_name() {

        config()->set('breadcrumbs.parentMethod', 'parent2');

        \App\Nova\LevelThreeD::$model = \App\Models\LevelThreeD2::class;

        $response = $this->get('/nova/resources/level-three-ds/1');
        $response->assertInertia(function (Assert $page) {
            $page->has('breadcrumbs', 7);
            $page->where('breadcrumbs.3.name', "Level Two As");
            $page->where('breadcrumbs.3.path', "/resources/level-two-as");
        });

        \App\Nova\LevelThreeD::$model = \App\Models\LevelThreeD3::class;
        $response = $this->get('/nova/resources/level-three-ds/1');
        $response->assertInertia(function (Assert $page) {
            $page->has('breadcrumbs', 5);
            $page->where('breadcrumbs.1.name', "Level Two Bs");
            $page->where('breadcrumbs.1.path', "/resources/level-two-bs");
        });
    }

    public function test_parent_via_model_return_type() {
        $response = $this->get('/nova/resources/level-two-a2s/1');
        $response->assertInertia(function (Assert $page) {
            $page->has('breadcrumbs', 5);
            $page->where('breadcrumbs.1.name', "Level Ones");
            $page->where('breadcrumbs.1.path', "/resources/level-ones");
            $page->where('breadcrumbs.2.name', "Test-1-Level-1");
            $page->where('breadcrumbs.2.path', "/resources/level-ones/1");
            $page->where('breadcrumbs.3.name', "Level Two A2s");
            $page->where('breadcrumbs.3.path', "/resources/level-two-a2s");
            $page->where('breadcrumbs.4.name', "Test-1-Level-2A");
            $page->where('breadcrumbs.4.path', "/resources/level-two-a2s/1");
        });
    }

}
