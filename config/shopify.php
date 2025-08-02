<?php

use Shopify\ApiVersion;

return [
    'api_key' => env('SHOPIFY_API_KEY'),
    'api_secret' => env('SHOPIFY_API_SECRET'),
    'api_scopes' => env('SHOPIFY_API_SCOPES'),
    'host_name' => env('SHOPIFY_HOST_NAME'),
    'api_version' => ApiVersion::LATEST,
    'is_embedded' => true,
    'is_private' => false,
];
