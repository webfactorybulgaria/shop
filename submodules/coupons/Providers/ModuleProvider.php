<?php

namespace TypiCMS\Modules\Coupons\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Shells\Facades\TypiCMS;
use TypiCMS\Modules\Core\Shells\Observers\FileObserver;
use TypiCMS\Modules\Core\Shells\Observers\SlugObserver;
use TypiCMS\Modules\Core\Shells\Services\Cache\LaravelCache;
use TypiCMS\Modules\Coupons\Shells\Models\Coupon;
use TypiCMS\Modules\Coupons\Shells\Repositories\CacheDecorator;
use TypiCMS\Modules\Coupons\Shells\Repositories\EloquentCoupon;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'typicms.coupons'
        );

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['coupons' => ['linkable_to_page']], $modules));

        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'coupons');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'coupons');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/coupons'),
        ], 'views');
        $this->publishes([
            __DIR__.'/../database' => base_path('database'),
        ], 'migrations');

        AliasLoader::getInstance()->alias(
            'Coupons',
            'TypiCMS\Modules\Coupons\Shells\Facades\Facade'
        );

        Coupon::observe(new FileObserver());
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Register route service provider
         */
        $app->register('TypiCMS\Modules\Coupons\Shells\Providers\RouteServiceProvider');

        /*
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', 'TypiCMS\Modules\Coupons\Shells\Composers\SidebarViewComposer');

        /*
         * Add the page in the view.
         */
        $app->view->composer('coupons::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('coupons');
        });

        $app->bind('TypiCMS\Modules\Coupons\Shells\Repositories\CouponInterface', function (Application $app) {
            $repository = new EloquentCoupon(new Coupon());
            if (!config('typicms.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], 'coupons', 10);

            return new CacheDecorator($repository, $laravelCache);
        });
    }
}
