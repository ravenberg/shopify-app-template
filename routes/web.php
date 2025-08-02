<?php

use App\Http\Controllers\ShopifyAuthController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

// Shopify OAuth routes
Route::middleware(['shopify.verify'])->group(function () {
    Route::get('/auth/shopify', [ShopifyAuthController::class, 'install'])->name('shopify.install');
    Route::get('/auth/shopify/callback', [ShopifyAuthController::class, 'callback'])->name('shopify.callback');
});

// Shopify webhooks (no CSRF protection needed)
Route::post('/webhooks/app/uninstalled', [ShopifyAuthController::class, 'uninstall'])
    ->withoutMiddleware(['web'])
    ->name('shopify.uninstall');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
