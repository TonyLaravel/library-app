<?php

use App\Http\Controllers\LoanController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/books/{book}/checkout', [LoanController::class, 'store'])
         ->name('loans.store');

    Route::patch('/loans/{loan}/return',  [LoanController::class, 'return'])
         ->name('loans.return');
});