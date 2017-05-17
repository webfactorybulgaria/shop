<?php

namespace TypiCMS\Modules\Shop\Providers;

use Illuminate\Routing\Router;
use TypiCMS\Modules\Core\Shells\Facades\TypiCMS;
use TypiCMS\Modules\Core\Shells\Providers\BaseRouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'TypiCMS\Modules\Shop\Shells\Http\Controllers';

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
            if ($page = TypiCMS::getPageLinkedToModule('shop')) {
                $options = $page->private ? ['middleware' => 'auth'] : [];
                foreach (config('translatable.locales') as $lang) {
                    if ($page->translate($lang)->status && $uri = $page->uri($lang)) {
                        $router->get($uri.'/basket', $options + ['as' => $lang.'.shop.basket', 'uses' => 'PublicController@basket']);
                        $router->get($uri.'/{itemId}/add/{quantity}', $options + ['as' => $lang.'.shop.add', 'uses' => 'PublicController@increaseItem']);
                        $router->get($uri.'/{itemId}/remove/{quantity?}', $options + ['as' => $lang.'.shop.remove', 'uses' => 'PublicController@removeItem']);

                        $router->get($uri.'/checkout', $options + ['as' => $lang.'.shop.checkout', 'uses' => 'PublicController@checkout']);
                        $options = ['middleware' => 'auth'];
                        $router->get($uri.'/callback', $options + ['as' => $lang.'.shop.callback', 'uses' => 'CallbackController@process']);
                        $router->post($uri.'/purchase', $options + ['as' => $lang.'.shop.purchase', 'uses' => 'PublicController@purchase']);
                        $router->get($uri.'/confirmation', $options + ['as' => $lang.'.shop.confirmation', 'uses' => 'PublicController@confirmation']);
                    }
                }
            }

            /*
             * Admin routes
             */
            $router->get('admin/shop', 'AdminController@preferences')->name('admin::index-shop'); //TODO - index page for the shop
            $router->get('admin/preferences', 'AdminController@preferences')->name('admin::preferences-shop');
            $router->post('admin/preferences', 'AdminController@storePreferences')->name('admin::storePreferences-shop');
        });
    }
}
