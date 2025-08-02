<?php

use Shopify\ApiVersion;
use Yosymfony\Toml\Toml;

/**
 * Parse TOML configuration from shopify.app.toml using yosymfony/toml library
 */
function parseShopifyToml(): array
{
    $tomlPath = base_path('shopify.app.toml');

    if (!file_exists($tomlPath)) {
        return [];
    }

    try {
        $parsedToml = Toml::parseFile($tomlPath);

        return [
            'client_id' => $parsedToml['client_id'] ?? '',
            'application_url' => $parsedToml['application_url'] ?? '',
            'embedded' => $parsedToml['embedded'] ?? true,
            'scopes' => $parsedToml['access_scopes']['scopes'] ?? '',
        ];
    } catch (Exception $e) {
        // If parsing fails, return empty array to fall back to environment variables
        return [];
    }
}

$shopifyConfig = parseShopifyToml();

return [
    'api_key' => !empty($shopifyConfig['client_id']) ? $shopifyConfig['client_id'] : env('SHOPIFY_API_KEY'),
    'api_secret' => env('SHOPIFY_API_SECRET'),
    'api_scopes' => !empty($shopifyConfig['scopes']) ? $shopifyConfig['scopes'] : env('SCOPES'),
    'host_name' => !empty($shopifyConfig['application_url']) ? parse_url($shopifyConfig['application_url'], PHP_URL_HOST) : parse_url(env('SHOPIFY_APP_URL', ''), PHP_URL_HOST),
    'api_version' => ApiVersion::LATEST,
    'is_embedded' => $shopifyConfig['embedded'] ?? true,
    'is_private' => false,
];
