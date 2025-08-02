<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Shopify\Auth\OAuth;
use Shopify\Auth\Session;
use Shopify\Context;
use Shopify\Exception\InvalidOAuthException;
use Shopify\Exception\SessionStorageException;
use Shopify\Utils;

class ShopifyAuthController extends Controller
{
    /**
     * Handle Shopify app installation/authentication
     */
    public function install(Request $request)
    {
        $shop = $request->query('shop');

        if (!$shop) {
            return response('Missing shop parameter', 400);
        }

        // Validate shop domain
        if (Utils::sanitizeShopDomain($shop) === null) {
            return response('Invalid shop domain', 400);
        }

        try {
            $authUrl = OAuth::begin(
                $shop,
                '/auth/shopify/callback',
                false // offline access
            );

            return redirect($authUrl);
        } catch (InvalidOAuthException $e) {
            Log::error('Shopify OAuth error: ' . $e->getMessage());
            return response('OAuth error', 500);
        }
    }

    /**
     * Handle Shopify OAuth callback
     */
    public function callback(Request $request)
    {
        try {
            $session = OAuth::callback(
                $request->cookie(),
                $request->query(),
                ['write_products'] // scopes
            );

            // Store session
            Context::$SESSION_STORAGE->storeSession($session);

            // Find or create shop
            $shop = Shop::firstOrCreate(
                ['shop' => $session->getShop()],
                [
                    'access_token' => $session->getAccessToken(),
                    'scope' => $session->getScope(),
                    'state' => $session->getState()
                ]
            );

            // Create or update user for this shop
            $user = User::firstOrCreate(
                ['email' => $session->getShop() . '@shopify.local'],
                [
                    'name' => $session->getShop(),
                    'password' => bcrypt(str()->random(32)),
                    'shop_id' => $shop->id
                ]
            );

            // Log the user in
            Auth::login($user);

            // Redirect to dashboard
            return redirect()->route('dashboard');

        } catch (InvalidOAuthException $e) {
            Log::error('Shopify OAuth callback error: ' . $e->getMessage());
            return response('OAuth callback error', 500);
        } catch (SessionStorageException $e) {
            Log::error('Session storage error: ' . $e->getMessage());
            return response('Session storage error', 500);
        }
    }

    /**
     * Handle app uninstallation
     */
    public function uninstall(Request $request)
    {
        // Verify webhook
        $hmac = $request->header('X-Shopify-Hmac-Sha256');
        $body = $request->getContent();
        $calculated = base64_encode(hash_hmac('sha256', $body, config('shopify.api_secret'), true));

        if (!hash_equals($hmac, $calculated)) {
            return response('Unauthorized', 401);
        }

        $data = json_decode($body, true);
        $shop = $data['domain'] ?? null;

        if ($shop) {
            // Remove shop and associated users
            $shopModel = Shop::where('shop', $shop)->first();
            if ($shopModel) {
                $shopModel->users()->delete();
                $shopModel->delete();
            }
        }

        return response('OK', 200);
    }
}
