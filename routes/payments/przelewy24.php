<?php

use App\Http\Controllers\Payments\Przelewy24Controller;
use Illuminate\Support\Facades\Route;

Route::post('/payments/przelewy24/status', [Przelewy24Controller::class, 'status'])->name('payments.przelewy24.status');
Route::get('/payments/przelewy24/callback', [Przelewy24Controller::class, 'callback'])->name('payments.przelewy24.callback');
