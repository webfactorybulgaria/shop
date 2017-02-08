<?php

namespace TypiCMS\Modules\Combinations\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use TypiCMS\Modules\Core\Shells\Facades\TypiCMS;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'TypiCMS\Modules\Combinations\Shells\Http\Controllers';

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function (Router $router) {

            /*
             * Front office routes
             */
            // if ($page = TypiCMS::getPageLinkedToModule('combinations')) {
            //     $options = $page->private ? ['middleware' => 'auth'] : [];
            //     foreach (config('translatable.locales') as $lang) {
            //         if ($page->translate($lang)->status && $uri = $page->uri($lang)) {
            //             $router->get($uri, $options + ['as' => $lang.'.combinations', 'uses' => 'PublicController@index']);
            //             $router->get($uri.'/{slug}', $options + ['as' => $lang.'.combinations.slug', 'uses' => 'PublicController@show']);
            //         }
            //     }
            // }

            /*
             * Admin routes
             */
            // $router->get('admin/combinations', 'AdminController@index')->name('admin::index-combinations');
            // $router->get('admin/combinations/create', 'AdminController@create')->name('admin::create-combination');
            // $router->get('admin/combinations/{combination}/edit', 'AdminController@edit')->name('admin::edit-combination');
            // $router->post('admin/combinations', 'AdminController@store')->name('admin::store-combination');
            // $router->put('admin/combinations/{combination}', 'AdminController@update')->name('admin::update-combination');

            /*
             * API routes
             */
            $router->get('api/combinations', 'ApiController@index')->name('api::index-combinations');
            $router->get('api/combinations/popup', 'ApiController@loadPopup')->name('api::loadPopup-combinations');
            $router->post('api/combinations', 'ApiController@store')->name('api::store-combination');
            $router->put('api/combinations', 'ApiController@update')->name('api::update-combination');
            $router->delete('api/combinations/{combination}', 'ApiController@destroy')->name('api::destroy-combination');
        });
    }
}
