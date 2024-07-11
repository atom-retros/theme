<?php

namespace Atom\Theme;

use Atom\Core\Models\User;
use Illuminate\Support\Facades\DB;
use Atom\Core\Models\WebsiteSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ThemeServiceProvider extends PackageServiceProvider
{
    /**
     * Configure the package.
     */
    public function configurePackage(Package $package): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'theme');

        if (Schema::hasTable('website_settings')) {
            $theme = DB::table('website_settings')
                ->where('key', 'theme')
                ->first();

            $this->loadJsonTranslationsFrom(
                resource_path(sprintf('views/%s/lang', $theme->value ?? 'atom')),
                'theme',
            );
        }

        $package
            ->name('theme')
            ->hasConfigFile()
            ->hasRoute('web')
            ->hasViews()
            ->runsMigrations();
    }

    /**
     * Boot the package services.
     */
    public function boot()
    {
        parent::boot();

        if (Schema::hasTable('website_settings')) {
            View::share('settings', WebsiteSetting::pluck('value', 'key'));
        }

        if (Schema::hasTable('users')) {
            View::share('online', User::where('online', '1')->count());
        }
    }
}
