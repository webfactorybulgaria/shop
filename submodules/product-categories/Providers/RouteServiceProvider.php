<?php

namespace TypiCMS\Modules\ProductCategories\Providers;

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
    protected $namespace = 'TypiCMS\Modules\ProductCategories\Shells\Http\Controllers';

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
            if ($page = TypiCMS::getPageLinkedToModule('product-categories')) {
                $options = $page->private ? ['middleware' => 'auth'] : [];
                foreach (config('translatable.locales') as $lang) {
                    if ($page->translate($lang)->status && $uri = $page->uri($lang)) {
                        $router->get($uri, $options + ['as' => $lang.'.product-categories', 'uses' => 'PublicController@index']);
                        $router->get($uri.'/{slug}', $options + ['as' => $lang.'.product-categories.slug', 'uses' => 'PublicController@show']);
                    }
                }
            }
            /*
             * Admin routes
             */
            $router->get('admin/product-categories', 'AdminController@index')->name('admin::index-product-categories');
            $router->get('admin/product-categories/create', 'AdminController@create')->name('admin::create-product-category');
            $router->get('admin/product-categories/{product_category}/edit', 'AdminController@edit')->name('admin::edit-product-category');
            $router->post('admin/product-categories', 'AdminController@store')->name('admin::store-product-category');
            $router->put('admin/product-categories/{product_category}', 'AdminController@update')->name('admin::update-product-category');

            /*
             * API routes
             */
            $router->get('api/product-categories', 'ApiController@index')->name('api::index-product-categories');
            $router->put('api/product-categories/{product_category}', 'ApiController@update')->name('api::update-product-category');
            $router->delete('api/product-categories/{product_category}', 'ApiController@destroy')->name('api::destroy-product-category');
        });
    }
}
