<?php

namespace Atom\Theme;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            path: __DIR__.'/../config/theme.php',
            key: 'theme'
        );

        $this->loadViewsFrom(
            path: __DIR__.'/../resources/views',
            namespace: 'theme',
        );

        $this->loadRoutesFrom(
            path: __DIR__.'/../routes/web.php'
        );

        $this->loadRoutesFrom(
            path: __DIR__.'/../routes/api.php'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            $onlineUsers = DB::table('users')
                ->where('online', '1')
                ->count();

            $settings = DB::table('website_settings')
                ->pluck('value', 'key');

            $this->loadJsonTranslationsFrom(
                resource_path(sprintf('views/%s/lang', $settings->get('theme', 'atom'))),
                'theme',
            );

            View::share('settings', $settings);

            View::share('online', $onlineUsers);
        } catch (\Throwable $e) {
            //
        }
    }
}
