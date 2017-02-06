<?php

namespace TypiCMS\Modules\Shop\Providers;

/*use Illuminate\Foundation\AliasLoader;*/
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Shells\Facades\TypiCMS;
/*use TypiCMS\Modules\Core\Shells\Observers\SlugObserver;*/

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $TypiCMSConfig = $this->app->make('TypiCMS\Modules\Settings\Shells\Repositories\SettingInterface')
            ->allToArray();

        $vendorConfig = $this->app['config']->get('shop', []);

        $this->app['config']->set('shop', array_merge_recursive($TypiCMSConfig['shop'], $vendorConfig));

        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'typicms.shop'
        );

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['shop' => ['linkable_to_page']], $modules));

        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'shop');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'shop');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/shop'),
        ], 'views');
        $this->publishes([
            __DIR__.'/../database' => base_path('database'),
        ], 'migrations');

    }

    public function register()
    {
        $app = $this->app;

        /*
         * Register route service provider
         */
        $app->register('TypiCMS\Modules\Shop\Shells\Providers\RouteServiceProvider');

        /*
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', 'TypiCMS\Modules\Shop\Shells\Composers\SidebarViewComposer');

        /*
         * Add the page in the view.
         */
        $app->view->composer('shop::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('shop');
        });
    }
}
