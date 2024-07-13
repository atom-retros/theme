<?php

use Atom\Theme\Http\Controllers\AccountSettingsController;
use Atom\Theme\Http\Controllers\ArticleController;
use Atom\Theme\Http\Controllers\ClientController;
use Atom\Theme\Http\Controllers\HelpCentreController;
use Atom\Theme\Http\Controllers\HomeController;
use Atom\Theme\Http\Controllers\IndexController;
use Atom\Theme\Http\Controllers\LeaderboardController;
use Atom\Theme\Http\Controllers\PasswordController;
use Atom\Theme\Http\Controllers\PhotoController;
use Atom\Theme\Http\Controllers\ProfileController;
use Atom\Theme\Http\Controllers\RareValueController;
use Atom\Theme\Http\Controllers\RuleController;
use Atom\Theme\Http\Controllers\ShopController;
use Atom\Theme\Http\Controllers\StaffApplicationController;
use Atom\Theme\Http\Controllers\StaffController;
use Atom\Theme\Http\Controllers\NitroController;
use Atom\Theme\Http\Controllers\TeamController;
use Atom\Theme\Http\Controllers\TicketController;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    Route::get('/', IndexController::class)
        ->middleware('guest')
        ->name('index');

    Route::get('profiles/{user:username}', ProfileController::class)
        ->middleware(Authenticate::using('sanctum'))
        ->name('profiles');

    Route::get('leaderboards', LeaderboardController::class)
        ->middleware(Authenticate::using('sanctum'))
        ->name('leaderboards');

    Route::get('rare-values', RareValueController::class)
        ->middleware(Authenticate::using('sanctum'))
        ->name('rare-values');

    Route::get('shop', ShopController::class)
        ->middleware(Authenticate::using('sanctum'))
        ->name('shop');

    Route::get('client', ClientController::class)
        ->middleware(Authenticate::using('sanctum'), 'voting.check')
        ->name('client');

    Route::name('game.')->prefix('game')->group(function () {
        Route::get('nitro', NitroController::class)
            ->middleware(Authenticate::using('sanctum'))
            ->name('nitro');
    });

    Route::name('users.')->prefix('users')->group(function () {
        Route::get('me', HomeController::class)
            ->middleware(Authenticate::using('sanctum'))
            ->name('me');

        Route::name('settings.')->prefix('settings')->group(function () {
            Route::resource('account', AccountSettingsController::class)
                ->middleware(Authenticate::using('sanctum'))
                ->only(['index', 'store']);

            Route::resource('password', PasswordController::class)
                ->middleware(Authenticate::using('sanctum'))
                ->only(['index', 'store']);
        });
    });

    Route::name('help-center.')->prefix('help-center')->group(function () {
        Route::get('/', HelpCentreController::class)
            ->middleware(Authenticate::using('sanctum'))
            ->name('index');

        Route::get('rules', RuleController::class)
            ->middleware(Authenticate::using('sanctum'))
            ->name('rules');

        Route::resource('tickets', TicketController::class)
            ->middleware(Authenticate::using('sanctum'))
            ->only(['index', 'create', 'store', 'show', 'destroy']);
    });

    Route::name('community.')->prefix('community')->group(function () {
        Route::get('teams', TeamController::class)
            ->middleware(Authenticate::using('sanctum'))
            ->name('teams');

        Route::get('staff', StaffController::class)
            ->middleware(Authenticate::using('sanctum'))
            ->name('staff');

        Route::resource('articles', ArticleController::class)
            ->middleware(Authenticate::using('sanctum'))
            ->only(['index', 'show']);

        Route::resource('staff-applications', StaffApplicationController::class)
            ->middleware(Authenticate::using('sanctum'))
            ->only(['index', 'show', 'store']);

        Route::get('photos', PhotoController::class)
            ->middleware(Authenticate::using('sanctum'))
            ->name('photos');
    });
});
