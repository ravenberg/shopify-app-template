<?php

namespace App\Providers;

use App\Shopify\SessionStorageDriver;
use Illuminate\Support\ServiceProvider;
use Shopify\Context;
use Shopify\Exception\MissingArgumentException;


class ShopifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     * @throws MissingArgumentException
     */
    public function boot(): void
    {
        Context::initialize(
            apiKey: config('shopify.api_key'),
            apiSecretKey: config('shopify.api_secret'),
            scopes: config('shopify.api_scopes'),
            hostName: config('shopify.host_name'),
            sessionStorage: new SessionStorageDriver(),
            apiVersion: config('shopify.api_version'),
            isEmbeddedApp: config('shopify.is_embedded'),
            isPrivateApp: config('shopify.is_private'),
        );
    }
}
