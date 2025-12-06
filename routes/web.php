<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.landing-page');
})->name('landing-page');

Route::match(['get', 'post'], '/add-data-transaction', [App\Http\Controllers\TransactionController::class, 'index'])->name('add-data-transaction');
