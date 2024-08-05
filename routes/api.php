<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Middleware\Authenticate;
use Atom\Theme\Http\Controllers\Api\UserController;
use Atom\Theme\Http\Controllers\Api\OnlineController;
use Atom\Theme\Http\Controllers\Api\HomeItemController;
use Atom\Theme\Http\Controllers\Api\HomeCategoryController;

Route::middleware('api')->prefix('api')->group(function () {
    Route::get('online', OnlineController::class)
        ->name('api.online');

    Route::get('users/{user:username}', UserController::class)
        ->name('api.users');

    Route::get('users/home/categories', HomeCategoryController::class)
        ->middleware(Authenticate::using('sanctum'))
        ->name('api.users.home.categories');

    Route::get('users/{user:username}/home/items', [HomeItemController::class, 'index'])
        ->middleware(Authenticate::using('sanctum'))
        ->name('api.users.home.items');

    Route::post('users/home/items', [HomeItemController::class, 'store'])
        ->middleware(Authenticate::using('sanctum'))
        ->name('api.users.home.items.store');

    Route::put('users/home/items', [HomeItemController::class, 'update'])
        ->middleware(Authenticate::using('sanctum'))
        ->name('api.users.home.items.update');
});
