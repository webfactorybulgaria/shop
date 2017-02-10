<?php

namespace TypiCMS\Modules\Orders\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Shells\Facades\TypiCMS;
use TypiCMS\Modules\Core\Shells\Observers\FileObserver;
use TypiCMS\Modules\Core\Shells\Observers\SlugObserver;
use TypiCMS\Modules\Core\Shells\Services\Cache\LaravelCache;
use TypiCMS\Modules\Orders\Shells\Models\Order;
use TypiCMS\Modules\Orders\Shells\Models\OrderTranslation;
use TypiCMS\Modules\Orders\Shells\Repositories\CacheDecorator;
use TypiCMS\Modules\Orders\Shells\Repositories\EloquentOrder;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'typicms.orders'
        );

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['orders' => ['srcDir' => __DIR__.'/../Shells/']], $modules));

        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'orders');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'orders');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/orders'),
        ], 'views');
        // $this->publishes([
        //     __DIR__.'/../database' => base_path('database'),
        // ], 'migrations');

        AliasLoader::getInstance()->alias(
            'Orders',
            'TypiCMS\Modules\Orders\Shells\Facades\Facade'
        );

        // Observers
        //OrderTranslation::observe(new SlugObserver());
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Register route service provider
         */
        $app->register('TypiCMS\Modules\Orders\Shells\Providers\RouteServiceProvider');

        /*
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', 'TypiCMS\Modules\Orders\Shells\Composers\SidebarViewComposer');

        /*
         * Add the page in the view.
        $app->view->composer('orders::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('orders');
        });
        */

        $app->bind('TypiCMS\Modules\Orders\Shells\Repositories\OrderInterface', function (Application $app) {
            $repository = new EloquentOrder(new Order());
            if (!config('typicms.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], 'orders', 10);

            return new CacheDecorator($repository, $laravelCache);
        });
    }
}
