<?php

namespace Tests\Feature\Breadcrumbs;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;
use Laravel\Nova\Nova;

class BreadcrumbsDefaultsTest extends TestCase
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

    public function test_nova_successful_response()
    {
        $response = $this->get('/nova/dashboards/main');

        $response->assertStatus(200);
    }

    public function test_nova_has_breadcrumbs()
    {
        $response = $this->get('/nova/dashboards/main');

        $response->assertInertia(function (Assert $page) {
            $page->has('breadcrumbs');
        });
    }

    public function test_middleware_applied_when_enabled() {
        Nova::withBreadcrumbs(true);

        $response = $this->get('/nova/dashboards/main');
        $response->assertInertia(function (Assert $page) {
            $page->has('breadcrumbs', 2, function (Assert $breadcrumbs) {
                $breadcrumbs->where('name', 'Home');
                $breadcrumbs->etc();
            });
        });
    }

    public function test_nova_breadcrumbs_can_be_disabled() {

        Nova::withBreadcrumbs(false);

        $response = $this->get('/nova/dashboards/main');
        $response->assertInertia(function (Assert $page) {
            $page->where('novaConfig.breadcrumbsEnabled', false);
        });
    }

    public function test_middleware_not_applied_when_disabled() {

        Nova::withBreadcrumbs(false);

        $response = $this->get('/nova/dashboards/main');
        $response->assertInertia(function (Assert $page) {
            $page->missing('breadcrumbs');
        });
    }

    public function test_final_breadcrumb_has_null_path() {
        $response = $this->get('/nova/dashboards/main');
        $response->assertInertia(function (Assert $page) {
            $page->has('breadcrumbs', 2);
            $page->where('breadcrumbs.1.path', null);
        });
    }

    public function test_breadcrumbs_are_correct_for_resource_index() {
        $response = $this->get('/nova/resources/level-ones');
        $response->assertInertia(function (Assert $page) {
            $page->has('breadcrumbs', 2);
            $page->where('breadcrumbs.1.name', "Level Ones");
        });
    }

    public function test_breadcrumbs_are_correct_for_resource_detail() {
        $response = $this->get('/nova/resources/level-ones/1');
        $response->assertInertia(function (Assert $page) {
            $page->has('breadcrumbs', 3);
            $page->where('breadcrumbs.1.name', "Level Ones");
            $page->where('breadcrumbs.1.path', "/resources/level-ones");
            $page->where('breadcrumbs.2.name', "Test-1-Level-1");
            $page->where('breadcrumbs.2.path', "/resources/level-ones/1");
        });
    }

    public function test_breadcrumbs_are_correct_for_resource_create() {
        $response = $this->get('/nova/resources/level-ones/new');
        $response->assertInertia(function (Assert $page) {
            $page->has('breadcrumbs', 3);
            $page->where('breadcrumbs.1.name', "Level Ones");
            $page->where('breadcrumbs.1.path', "/resources/level-ones");
            $page->where('breadcrumbs.2.name', "Create");
            $page->where('breadcrumbs.2.path', null);
        });
    }

    public function test_breadcrumbs_are_correct_for_resource_edit() {
        $response = $this->get('/nova/resources/level-ones/1/edit');
        $response->assertInertia(function (Assert $page) {
            $page->has('breadcrumbs', 4);
            $page->where('breadcrumbs.1.name', "Level Ones");
            $page->where('breadcrumbs.1.path', "/resources/level-ones");
            $page->where('breadcrumbs.2.name', "Test-1-Level-1");
            $page->where('breadcrumbs.2.path', "/resources/level-ones/1");
            $page->where('breadcrumbs.3.name', "Update");
            $page->where('breadcrumbs.3.path', null);
        });
    }

    public function test_breadcrumbs_are_correct_for_child_resource_level_2_detail() {
        $response = $this->get('/nova/resources/level-two-as/1');
        $response->assertInertia(function (Assert $page) {
            $page->has('breadcrumbs', 5);
            $page->where('breadcrumbs.1.name', "Level Ones");
            $page->where('breadcrumbs.1.path', "/resources/level-ones");
            $page->where('breadcrumbs.2.name', "Test-1-Level-1");
            $page->where('breadcrumbs.2.path', "/resources/level-ones/1");
            $page->where('breadcrumbs.3.name', "Level Two As");
            $page->where('breadcrumbs.3.path', "/resources/level-two-as");
            $page->where('breadcrumbs.4.name', "Test-1-Level-2A");
            $page->where('breadcrumbs.4.path', "/resources/level-two-as/1");
        });
    }

    public function test_breadcrumbs_are_correct_for_child_resource_level_2_create_via() {
        $response = $this->get('/nova/resources/level-two-as/new?viaResource=level-ones&viaResourceId=1&viaRelationship=levelTwoA&relationshipType=hasMany');
        $response->assertInertia(function (Assert $page) {
            $page->has('breadcrumbs', 5);
            $page->where('breadcrumbs.1.name', "Level Ones");
            $page->where('breadcrumbs.1.path', "/resources/level-ones");
            $page->where('breadcrumbs.2.name', "Test-1-Level-1");
            $page->where('breadcrumbs.2.path', "/resources/level-ones/1");
            $page->where('breadcrumbs.3.name', "Level Two As");
            $page->where('breadcrumbs.3.path', "/resources/level-two-as");
            $page->where('breadcrumbs.4.name', "Create");
            $page->where('breadcrumbs.4.path', null);
        });
    }

    public function test_breadcrumbs_are_correct_for_child_resource_level_2_create() {
        $response = $this->get('/nova/resources/level-two-as/new');
        $response->assertInertia(function (Assert $page) {
            $page->has('breadcrumbs', 3);
            $page->where('breadcrumbs.1.name', "Level Two As");
            $page->where('breadcrumbs.1.path', "/resources/level-two-as");
            $page->where('breadcrumbs.2.name', "Create");
            $page->where('breadcrumbs.2.path', null);
        });
    }

    public function test_breadcrumbs_are_correct_for_child_resource_level_2_edit() {
        $response = $this->get('/nova/resources/level-two-as/1/edit');
        $response->assertInertia(function (Assert $page) {
            $page->has('breadcrumbs', 6);
            $page->where('breadcrumbs.1.name', "Level Ones");
            $page->where('breadcrumbs.1.path', "/resources/level-ones");
            $page->where('breadcrumbs.2.name', "Test-1-Level-1");
            $page->where('breadcrumbs.2.path', "/resources/level-ones/1");
            $page->where('breadcrumbs.3.name', "Level Two As");
            $page->where('breadcrumbs.3.path', "/resources/level-two-as");
            $page->where('breadcrumbs.4.name', "Test-1-Level-2A");
            $page->where('breadcrumbs.4.path', "/resources/level-two-as/1");
            $page->where('breadcrumbs.5.name', "Update");
            $page->where('breadcrumbs.5.path', null);
        });
    }

    public function test_breadcrumbs_are_correct_for_child_resource_level_2B_attach() {
        $response = $this->get('/nova/resources/level-ones/1/attach/level-two-bs?viaRelationship=levelTwoBs&polymorphic=0');
        $response->assertInertia(function (Assert $page) {
            $page->has('breadcrumbs', 5);
            $page->where('breadcrumbs.1.name', "Level Ones");
            $page->where('breadcrumbs.1.path', "/resources/level-ones");
            $page->where('breadcrumbs.2.name', "Test-1-Level-1");
            $page->where('breadcrumbs.2.path', "/resources/level-ones/1");
            $page->where('breadcrumbs.3.name', "Level Two Bs");
            $page->where('breadcrumbs.3.path', "/resources/level-two-bs");
            $page->where('breadcrumbs.4.name', "Attach");
            $page->where('breadcrumbs.4.path', null);
        });
    }

    public function test_breadcrumbs_are_correct_for_child_resource_level_3_detail() {
        $response = $this->get('/nova/resources/level-three-as/1');
        $response->assertInertia(function (Assert $page) {
            $page->has('breadcrumbs', 7);
            $page->where('breadcrumbs.1.name', "Level Ones");
            $page->where('breadcrumbs.1.path', "/resources/level-ones");
            $page->where('breadcrumbs.2.name', "Test-1-Level-1");
            $page->where('breadcrumbs.2.path', "/resources/level-ones/1");
            $page->where('breadcrumbs.3.name', "Level Two As");
            $page->where('breadcrumbs.3.path', "/resources/level-two-as");
            $page->where('breadcrumbs.4.name', "Test-1-Level-2A");
            $page->where('breadcrumbs.4.path', "/resources/level-two-as/1");
            $page->where('breadcrumbs.5.name', "Level Three As");
            $page->where('breadcrumbs.5.path', "/resources/level-three-as");
            $page->where('breadcrumbs.6.name', "Test-1-Level-3A");
            $page->where('breadcrumbs.6.path', "/resources/level-three-as/1");
        });
    }

    public function test_breadcrumbs_are_correct_for_child_resource_level_3_create_via() {
        $response = $this->get('/nova/resources/level-three-as/new?viaResource=level-two-as&viaResourceId=1&viaRelationship=levelThreeA&relationshipType=hasMany');
        $response->assertInertia(function (Assert $page) {
            $page->has('breadcrumbs', 7);
            $page->where('breadcrumbs.1.name', "Level Ones");
            $page->where('breadcrumbs.1.path', "/resources/level-ones");
            $page->where('breadcrumbs.2.name', "Test-1-Level-1");
            $page->where('breadcrumbs.2.path', "/resources/level-ones/1");
            $page->where('breadcrumbs.3.name', "Level Two As");
            $page->where('breadcrumbs.3.path', "/resources/level-two-as");
            $page->where('breadcrumbs.4.name', "Test-1-Level-2A");
            $page->where('breadcrumbs.4.path', "/resources/level-two-as/1");
            $page->where('breadcrumbs.5.name', "Level Three As");
            $page->where('breadcrumbs.5.path', "/resources/level-three-as");
            $page->where('breadcrumbs.6.name', "Create");
            $page->where('breadcrumbs.6.path', null);
        });
    }

    public function test_breadcrumbs_are_correct_for_child_resource_level_3_create() {
        $response = $this->get('/nova/resources/level-three-as/new');
        $response->assertInertia(function (Assert $page) {
            $page->has('breadcrumbs', 3);
            $page->where('breadcrumbs.1.name', "Level Three As");
            $page->where('breadcrumbs.1.path', "/resources/level-three-as");
            $page->where('breadcrumbs.2.name', "Create");
            $page->where('breadcrumbs.2.path', null);
        });
    }

    public function test_breadcrumbs_are_correct_for_child_resource_level_3_edit() {
        $response = $this->get('/nova/resources/level-three-as/1/edit');
        $response->assertInertia(function (Assert $page) {
            $page->has('breadcrumbs', 8);
            $page->where('breadcrumbs.1.name', "Level Ones");
            $page->where('breadcrumbs.1.path', "/resources/level-ones");
            $page->where('breadcrumbs.2.name', "Test-1-Level-1");
            $page->where('breadcrumbs.2.path', "/resources/level-ones/1");
            $page->where('breadcrumbs.3.name', "Level Two As");
            $page->where('breadcrumbs.3.path', "/resources/level-two-as");
            $page->where('breadcrumbs.4.name', "Test-1-Level-2A");
            $page->where('breadcrumbs.4.path', "/resources/level-two-as/1");
            $page->where('breadcrumbs.5.name', "Level Three As");
            $page->where('breadcrumbs.5.path', "/resources/level-three-as");
            $page->where('breadcrumbs.6.name', "Test-1-Level-3A");
            $page->where('breadcrumbs.6.path', "/resources/level-three-as/1");
            $page->where('breadcrumbs.7.name', "Update");
            $page->where('breadcrumbs.7.path', null);
        });
    }
}
