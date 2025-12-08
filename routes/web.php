<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.landing-page');
})->name('landing-page');

Route::match(['get', 'post'], '/data-transaction', [App\Http\Controllers\TransactionController::class, 'index'])->name('data-transaction');
Route::match(['get', 'post'], '/data-transaction/edit', [App\Http\Controllers\TransactionController::class, 'edit'])->name('edit-data-transaction');
Route::get('/data-transaction/list', [App\Http\Controllers\TransactionController::class, 'list'])->name('list-data-transaction');
