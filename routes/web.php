<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaystackController;
use App\Http\Controllers\DisplayController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('callback', [PaystackController::class, 'callback'])->name('callback');
Route::get('success', [PaystackController::class, 'success'])->name('success');
Route::get('cancel', [PaystackController::class, 'cancel'])->name('cancel');

//Display all record from db and do refund if required
Route::get('display', [DisplayController::class, 'display'])->name('display');
Route::get('refund/{id?}', [PaystackController::class, 'refund'])->name('refund');