<?php

namespace TypiCMS\Modules\Products\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Shells\Facades\TypiCMS;
use TypiCMS\Modules\Core\Shells\Observers\FileObserver;
use TypiCMS\Modules\Core\Shells\Observers\SlugObserver;
use TypiCMS\Modules\Core\Shells\Services\Cache\LaravelCache;
use TypiCMS\Modules\Products\Shells\Models\Product;
use TypiCMS\Modules\Products\Shells\Models\ProductPrice;
use TypiCMS\Modules\Products\Shells\Models\ProductTranslation;
use TypiCMS\Modules\Products\Shells\Repositories\CacheDecorator;
use TypiCMS\Modules\Products\Shells\Repositories\PriceCacheDecorator;
use TypiCMS\Modules\Products\Shells\Repositories\EloquentProduct;
use TypiCMS\Modules\Products\Shells\Repositories\EloquentProductPrice;
use TypiCMS\Modules\Attributes\Shells\Observers\AttributeGroupObserver;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'typicms.products'
        );

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['products' => ['linkable_to_page', 'srcDir' => __DIR__.'/../Shells/']], $modules));

        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'products');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'products');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/products'),
        ], 'views');
        $this->publishes([
            __DIR__.'/../database' => base_path('database'),
        ], 'migrations');
        $this->publishes([
            __DIR__.'/../resources/assets/' => base_path('resources/assets/typicms/products'),
        ], 'assets');

        AliasLoader::getInstance()->alias(
            'Products',
            'TypiCMS\Modules\Products\Shells\Facades\Facade'
        );

        // Observers
        ProductTranslation::observe(new SlugObserver());
        Product::observe(new FileObserver());
        Product::observe(new AttributeGroupObserver());
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Register route service provider
         */
        $app->register('TypiCMS\Modules\Products\Shells\Providers\RouteServiceProvider');

        /*
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', 'TypiCMS\Modules\Products\Shells\Composers\SidebarViewComposer');

        /*
         * Add the page in the view.
         */
        $app->view->composer('products::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('products');
        });

        $app->bind('TypiCMS\Modules\Products\Shells\Repositories\ProductInterface', function (Application $app) {
            $repository = new EloquentProduct(new Product());
            if (!config('typicms.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], ['products', 'attributes'], 10);

            return new CacheDecorator($repository, $laravelCache);
        });

        $app->bind('TypiCMS\Modules\Products\Shells\Repositories\ProductPriceInterface', function (Application $app) {
            $repository = new EloquentProductPrice(new ProductPrice());
            if (!config('typicms.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], ['product_prices'], 10);

            return new PriceCacheDecorator($repository, $laravelCache);
        });
    }
}
