<?php

namespace App\Nova;

use Formfeed\Breadcrumbs\Breadcrumb;
use Formfeed\Breadcrumbs\Breadcrumbs;
use Illuminate\Http\Request;
use Laravel\Nova\Fields;
use Laravel\Nova\Http\Requests\NovaRequest;

class LevelTwoC extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\LevelTwoC>
     */
    public static $model = \App\Models\LevelTwoC::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    public function indexBreadcrumb(NovaRequest $request, BreadCrumbs $breadcrumbs, Breadcrumb $breadcrumb) {
        return Breadcrumb::make(__("Index Override"));
    }

    public function detailBreadcrumb(NovaRequest $request, BreadCrumbs $breadcrumbs, Breadcrumb $breadcrumb) {
        return Breadcrumb::make(__("Detail Override"));
    }

    public function formBreadcrumb(NovaRequest $request, BreadCrumbs $breadcrumbs, Breadcrumb $breadcrumb, $type) {
        return Breadcrumb::make(__("Form Override :type", ['type' => $type]));
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Fields\ID::make()->sortable(),
            Fields\Text::make("Name"),
            Fields\BelongsTo::make("Level One", "levelOne", LevelOne::class),
            Fields\HasMany::make("Level Three B", "levelThreeB", LevelThreeB::class),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
