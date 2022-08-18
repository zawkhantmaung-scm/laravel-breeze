<?php

use App\Http\Controllers\ElementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentLinkController;

Route::middleware('auth')->group(function () {
    # Recommended integrations: Stripe Payment Links
    Route::prefix('payment-link')->name('payment.link.')->group(function () {
            Route::get('/plan', [PaymentLinkController::class, 'plan'])->name('plan');
            Route::post('/payment', [PaymentLinkController::class, 'payment'])->name('payment');
            Route::get('/success', [PaymentLinkController::class, 'success'])->name('success');
    });

    # Recommended integrations: Stripe Elements
    Route::prefix('element')->name('element.')->group(function () {
            Route::get('/plan', [ElementController::class, 'plan'])->name('plan');
            Route::post('/payment', [ElementController::class, 'payment'])->name('payment');
            Route::get('/success', [ElementController::class, 'success'])->name('success');
    });
});