<?php

namespace TypiCMS\Modules\ProductCategories\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Shells\Facades\TypiCMS;
use TypiCMS\Modules\Core\Shells\Observers\FileObserver;
use TypiCMS\Modules\Core\Shells\Observers\SlugObserver;
use TypiCMS\Modules\Core\Shells\Services\Cache\LaravelCache;
use TypiCMS\Modules\ProductCategories\Shells\Models\ProductCategory;
use TypiCMS\Modules\ProductCategories\Shells\Models\ProductCategoryTranslation;
use TypiCMS\Modules\ProductCategories\Shells\Repositories\CacheDecorator;
use TypiCMS\Modules\ProductCategories\Shells\Repositories\EloquentProductCategory;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'typicms.product-categories'
        );

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['product-categories' => ['linkable_to_page', 'srcDir' => __DIR__.'/../Shells/']], $modules));

        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'product-categories');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'product-categories');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/product-categories'),
        ], 'views');
        $this->publishes([
            __DIR__.'/../database' => base_path('database'),
        ], 'migrations');
        $this->publishes([
            __DIR__.'/../resources/assets/' => base_path('resources/assets/typicms/product-categories'),
        ], 'assets');

        AliasLoader::getInstance()->alias(
            'ProductCategories',
            'TypiCMS\Modules\ProductCategories\Shells\Facades\Facade'
        );

        // Observers
        ProductCategoryTranslation::observe(new SlugObserver());
        ProductCategory::observe(new FileObserver());
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Register route service provider
         */
        $app->register('TypiCMS\Modules\ProductCategories\Shells\Providers\RouteServiceProvider');

        /*
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', 'TypiCMS\Modules\ProductCategories\Shells\Composers\SidebarViewComposer');

        /*
         * Add the page in the view.
         */
        $app->view->composer('product-categories::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('product-categories');
        });

        $app->bind('TypiCMS\Modules\ProductCategories\Shells\Repositories\ProductCategoryInterface', function (Application $app) {
            $repository = new EloquentProductCategory(new ProductCategory());
            if (!config('typicms.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], ['product-categories'], 10);

            return new CacheDecorator($repository, $laravelCache);
        });

    }
}
