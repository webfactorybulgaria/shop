<?php

namespace TypiCMS\Modules\Coupons\Providers;

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
    protected $namespace = 'TypiCMS\Modules\Coupons\Shells\Http\Controllers';

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
             * Admin routes
             */
            $router->get('admin/coupons', 'AdminController@index')->name('admin::index-coupons');
            $router->get('admin/coupons/create', 'AdminController@create')->name('admin::create-coupon');
            $router->get('admin/coupons/{coupon}/edit', 'AdminController@edit')->name('admin::edit-coupon');
            $router->post('admin/coupons', 'AdminController@store')->name('admin::store-coupon');
            $router->put('admin/coupons/{coupon}', 'AdminController@update')->name('admin::update-coupon');

            /*
             * API routes
             */
            $router->get('api/coupons', 'ApiController@index')->name('api::index-coupons');
            $router->get('api/coupons/process', 'ApiController@process')->name('api::process-coupon');
            $router->get('api/coupons/remove', 'ApiController@remove')->name('api::remove-coupon');
            $router->put('api/coupons/{coupon}', 'ApiController@update')->name('api::update-coupon');
            $router->delete('api/coupons/{coupon}', 'ApiController@destroy')->name('api::destroy-coupon');
        });
    }
}
