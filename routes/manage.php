<?php

use App\Http\Middleware\IsLibrarian;
use App\Http\Controllers\ManageBookController;

Route::middleware(['auth', 'verified', IsLibrarian::class,])
    ->prefix('manage')
    ->name('manage.')
    ->group(function () {
        Route::resource('books', ManageBookController::class)
            ->except(['show']);
    });
