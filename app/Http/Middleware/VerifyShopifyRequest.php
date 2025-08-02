<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Shopify\Utils;

class VerifyShopifyRequest
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Skip verification for webhook routes (they have their own verification)
        if ($request->is('webhooks/*')) {
            return $next($request);
        }

        // For OAuth callback, verify the HMAC
        if ($request->is('auth/shopify/callback')) {
            return $this->verifyOAuthCallback($request, $next);
        }

        // For embedded app requests, verify the shop parameter
        if ($request->has('shop')) {
            $shop = $request->query('shop');

            if (Utils::sanitizeShopDomain($shop) === null) {
                Log::warning('Invalid shop domain: ' . $shop);
                return response('Invalid shop domain', 400);
            }
        }

        return $next($request);
    }

    /**
     * Verify OAuth callback request
     */
    private function verifyOAuthCallback(Request $request, Closure $next)
    {
        $hmac = $request->query('hmac');
        $shop = $request->query('shop');

        if (!$hmac || !$shop) {
            Log::warning('Missing HMAC or shop parameter in OAuth callback');
            return response('Missing required parameters', 400);
        }

        // Verify shop domain
        if (Utils::sanitizeShopDomain($shop) === null) {
            Log::warning('Invalid shop domain in OAuth callback: ' . $shop);
            return response('Invalid shop domain', 400);
        }

        // Build query string for HMAC verification
        $queryParams = $request->query();
        unset($queryParams['hmac']);
        unset($queryParams['signature']);

        ksort($queryParams);
        $queryString = http_build_query($queryParams);

        // Calculate expected HMAC
        $expectedHmac = hash_hmac('sha256', $queryString, config('shopify.api_secret'));

        if (!hash_equals($expectedHmac, $hmac)) {
            Log::warning('HMAC verification failed for OAuth callback');
            return response('HMAC verification failed', 401);
        }

        return $next($request);
    }
}
