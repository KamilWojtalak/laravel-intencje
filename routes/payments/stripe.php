<?php

use App\Http\Controllers\Payments\StripeController;
use Illuminate\Support\Facades\Route;

Route::get('/payments/stripe', [StripeController::class, 'index'])->name('payments.stripe.index');
Route::post('/payments/stripe', [StripeController::class, 'store'])->name('payments.stripe.store');
Route::post('/payments/stripe/status', [StripeController::class, 'status'])->name('payments.stripe.status');
Route::get('/payments/stripe/success', [StripeController::class, 'success'])->name('payments.stripe.success');
Route::get('/payments/stripe/cancel', [StripeController::class, 'cancel'])->name('payments.stripe.cancel');
