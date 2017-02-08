<?php

namespace TypiCMS\Modules\Combinations\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Shells\Facades\TypiCMS;
use TypiCMS\Modules\Core\Shells\Observers\FileObserver;
use TypiCMS\Modules\Core\Shells\Observers\SlugObserver;
use TypiCMS\Modules\Core\Shells\Services\Cache\LaravelCache;
use TypiCMS\Modules\Combinations\Shells\Models\Combination;
use TypiCMS\Modules\Combinations\Shells\Repositories\CacheDecorator;
use TypiCMS\Modules\Combinations\Shells\Repositories\EloquentCombination;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'typicms.combinations'
        );

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['combinations' => ['srcDir' => __DIR__.'/../Shells/']], $modules));

        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'combinations');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'combinations');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/combinations'),
        ], 'views');
        $this->publishes([
            __DIR__.'/../database' => base_path('database'),
        ], 'migrations');

        AliasLoader::getInstance()->alias(
            'Combinations',
            'TypiCMS\Modules\Combinations\Shells\Facades\Facade'
        );

        // Observers
        Combination::observe(new FileObserver());
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Register route service provider
         */
        $app->register('TypiCMS\Modules\Combinations\Shells\Providers\RouteServiceProvider');

        /*
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', 'TypiCMS\Modules\Combinations\Shells\Composers\SidebarViewComposer');

        /*
         * Add the page in the view.
         */
        $app->view->composer('combinations::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('combinations');
        });

        $app->bind('TypiCMS\Modules\Combinations\Shells\Repositories\CombinationInterface', function (Application $app) {
            $repository = new EloquentCombination(new Combination());
            if (!config('typicms.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], 'combinations', 10);

            return new CacheDecorator($repository, $laravelCache);
        });
    }
}
