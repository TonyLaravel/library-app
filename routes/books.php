<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/books', [BookController::class, 'index'])->name('books');
Route::get('/books/{slug}', [BookController::class, 'show'])->name('books.show');

Route::middleware('auth')->group(function () {
    Route::post('/books/{slug}/comments', [BookController::class, 'storeComment'])->name('books.comments.store');
    Route::post('/books/{slug}/ratings', [BookController::class, 'storeRating'])->name('books.ratings.store');
});