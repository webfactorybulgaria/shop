<?php

namespace TypiCMS\Modules\Products\Providers;

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
    protected $namespace = 'TypiCMS\Modules\Products\Shells\Http\Controllers';

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
            if ($page = TypiCMS::getPageLinkedToModule('products')) {
                $options = $page->private ? ['middleware' => 'auth'] : [];
                foreach (config('translatable.locales') as $lang) {
                    if ($page->translate($lang)->status && $uri = $page->uri($lang)) {
                        $router->get($uri, $options + ['as' => $lang.'.products', 'uses' => 'PublicController@index']);
                        /*$router->get($uri.'/basket', $options + ['as' => $lang.'.products.basket', 'uses' => 'PublicController@basket']);*/
                        $router->get($uri.'/{slug}', $options + ['as' => $lang.'.products.slug', 'uses' => 'PublicController@show']);
                        //$router->get($uri.'/{slug}/add', $options + ['as' => $lang.'.products.add', 'uses' => 'PublicController@add']);
                        $router->post($uri.'/{slug}/add', $options + ['as' => $lang.'.products.add', 'uses' => 'PublicController@add']);
                    }
                }
            }

            /*
             * Admin routes
             */
            $router->get('admin/products', 'AdminController@index')->name('admin::index-products');
            $router->get('admin/products/create', 'AdminController@create')->name('admin::create-product');
            $router->get('admin/products/{product}/edit', 'AdminController@edit')->name('admin::edit-product');
            $router->post('admin/products', 'AdminController@store')->name('admin::store-product');
            $router->put('admin/products/{product}', 'AdminController@update')->name('admin::update-product');

            $router->get('admin/products/{product}/prices', 'PricesAdminController@index')->name('admin::index-productprices');
            $router->get('admin/products/{product}/prices/create', 'PricesAdminController@create')->name('admin::create-productprice');
            $router->get('admin/products/{product}/prices/{price}/edit', 'PricesAdminController@edit')->name('admin::edit-productprice');
            $router->post('admin/products/{product}/prices', 'PricesAdminController@store')->name('admin::store-productprice');
            $router->put('admin/products/{product}/prices/{price}', 'PricesAdminController@update')->name('admin::update-productprice');

            /*
             * API routes
             */
            $router->get('api/products', 'ApiController@index')->name('api::index-products');
            $router->get('api/products/{product}', 'ApiController@getOne')->name('api::getOne-product');
            $router->put('api/products/{product}', 'ApiController@update')->name('api::update-product');
            $router->delete('api/products/{product}', 'ApiController@destroy')->name('api::destroy-product');
            $router->post('api/products/combinations', 'ApiController@combinations')->name('api::combinations-products');
            $router->get('api/products/combinations/{product}', 'ApiController@getProductCombinations')->name('api::getProductCombinations-products');

            $router->delete('api/productsprices/{price}', 'PricesApiController@destroy')->name('api::destroy-product');
        });
    }
}
