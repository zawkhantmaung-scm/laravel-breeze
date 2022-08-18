<?php

use App\Http\Controllers\ElementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentLinkController;

Route::middleware('auth')->group(function () {
    # Recommended integrations: Stripe Payment Links
    Route::prefix('payment-link')->name('payment.link.')->group(function () {
            Route::get('/plan', [PaymentLinkController::class, 'plan'])->name('plan');
            Route::post('/payment', [PaymentLinkController::class, 'payment'])->name('payment');
            Route::get('/verify', [PaymentLinkController::class, 'verify'])->name('verify');
            Route::get('/success', [PaymentLinkController::class, 'success'])->name('success');
            Route::get('/fail', [PaymentLinkController::class, 'fail'])->name('fail');
    });

    # Recommended integrations: Stripe Elements
    Route::prefix('element')->name('element.')->group(function () {
            Route::get('/plan', [ElementController::class, 'plan'])->name('plan');
            Route::post('/payment', [ElementController::class, 'payment'])->name('payment');
            Route::get('/verify', [ElementController::class, 'verify'])->name('verify');
            Route::get('/success', [ElementController::class, 'success'])->name('success');
            Route::get('/fail', [ElementController::class, 'fail'])->name('fail');
    });
});