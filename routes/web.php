<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

require __DIR__.'/books.php';
require __DIR__.'/loans.php';
require __DIR__.'/profile.php';
require __DIR__.'/manage.php';
require __DIR__.'/auth.php';
