<?php

namespace Atom\Theme;

use Atom\Core\Models\User;
use Atom\Core\Models\WebsiteSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
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

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'theme');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'theme');

        $package
            ->name('theme')
            ->hasConfigFile()
            ->hasRoute('web')
            ->hasViews()
            ->hasTranslations()
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
