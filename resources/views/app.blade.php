<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <link rel="preconnect" href="https://cdn.shopify.com/" />
    <link
        rel="stylesheet"
        href="https://cdn.shopify.com/static/fonts/inter/v4/styles.css"
    />
    <meta name="shopify-api-key" content="{{ $page['props']['apiKey'] }}" />
    <script src='https://cdn.shopify.com/shopifycloud/app-bridge.js' data-api-key="{{ $page['props']['apiKey'] }}" />

    @routes
    @viteReactRefresh
    @vite(['resources/js/app.tsx', "resources/js/pages/{$page['component']}.tsx"])
    @inertiaHead
</head>
<body>
@inertia
</body>
</html>
