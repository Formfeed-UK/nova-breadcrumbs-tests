<?php

namespace Tests\Feature\Breadcrumbs;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Formfeed\Breadcrumbs\Breadcrumb;
use Formfeed\Breadcrumbs\Breadcrumbs;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;

class BreadcrumbsPropertyTest extends TestCase
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

    public function test_should_link_to_parent_property() {
        \App\Nova\LevelTwoA::$linkToParent = true;

        $response = $this->get('/nova/resources/level-two-as/1');

        $response->assertInertia(function (Assert $page) {
            $page->has('breadcrumbs', 5);
            $page->where('breadcrumbs.3.name', "Level Two As");
            $page->where('breadcrumbs.3.path', "/resources/level-ones/1");
        });

        \App\Nova\LevelTwoA::$linkToParent = false;
    }

    public function test_dont_resolve_parent_breadcrumbs() {
        \App\Nova\LevelTwoA::$resolveParentBreadcrumbs = false;

        $response = $this->get('/nova/resources/level-two-as/1');

        $response->assertInertia(function (Assert $page) {
            $page->has('breadcrumbs', 3);
            $page->where('breadcrumbs.2.name', "Test-1-Level-2A");
            $page->where('breadcrumbs.2.path', "/resources/level-two-as/1");
        });

        \App\Nova\LevelTwoA::$resolveParentBreadcrumbs = true;
    }

}
