<?php

use App\Http\Controllers\ShopifyAuthController;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('shopify install redirects to oauth when shop parameter is provided', function () {
    $response = $this->get('/auth/shopify?shop=test-shop.myshopify.com');

    $response->assertStatus(302);
    $response->assertRedirectContains('myshopify.com');
});

test('shopify install returns error when shop parameter is missing', function () {
    $response = $this->get('/auth/shopify');

    $response->assertStatus(400);
    $response->assertSeeText('Missing shop parameter');
});

test('shopify install returns error when shop domain is invalid', function () {
    $response = $this->get('/auth/shopify?shop=invalid-domain');

    $response->assertStatus(400);
    $response->assertSeeText('Invalid shop domain');
});

test('webhook uninstall removes shop and users when valid hmac provided', function () {
    // Create a shop and user
    $shop = Shop::factory()->create(['shop' => 'test-shop.myshopify.com']);
    $user = User::factory()->create(['shop_id' => $shop->id]);

    $webhookData = json_encode(['domain' => 'test-shop.myshopify.com']);
    $hmac = base64_encode(hash_hmac('sha256', $webhookData, config('shopify.api_secret'), true));

    $response = $this->post('/webhooks/app/uninstalled', json_decode($webhookData, true), [
        'X-Shopify-Hmac-Sha256' => $hmac,
        'Content-Type' => 'application/json'
    ]);

    $response->assertStatus(200);
    $this->assertDatabaseMissing('shops', ['shop' => 'test-shop.myshopify.com']);
    $this->assertDatabaseMissing('users', ['id' => $user->id]);
});

test('webhook uninstall returns unauthorized when hmac is invalid', function () {
    $webhookData = json_encode(['domain' => 'test-shop.myshopify.com']);

    $response = $this->post('/webhooks/app/uninstalled', json_decode($webhookData, true), [
        'X-Shopify-Hmac-Sha256' => 'invalid-hmac',
        'Content-Type' => 'application/json'
    ]);

    $response->assertStatus(401);
});
