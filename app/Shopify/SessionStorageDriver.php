<?php

namespace App\Shopify;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Shopify\Auth\Session;
use Shopify\Auth\SessionStorage;

/**
 * Shopify Storage driver for Laravel based on database storage through the Shop and User models.
 */
class SessionStorageDriver implements SessionStorage
{
    public function storeSession(Session $session): bool
    {
        $shop = Shop::query()->updateOrCreate(['shop' => $session->getShop()]);

        if ($session->isOnline()) {
            $userInfo = $session->getOnlineAccessInfo();
            // Store online session info on the User model
            $shop->users()->updateOrCreate(
                ['shopify_user_id' => $userInfo->getId()],
                [
                    'name' => "{$userInfo->getFirstName()} {$userInfo->getLastName()}",
                    'email' => $userInfo->getEmail(),
                    'password' => Hash::make(str()->random(20)), // Dummy password
                    'shopify_access_token' => $session->getAccessToken(),
                    'shopify_token_expires_at' => $session->getExpires(),
                ]
            );
        } else {
            // Store offline session info on the Shop model
            $shop->state = $session->getState();
            $shop->scope = $session->getScope();
            $shop->access_token = $session->getAccessToken();
            $shop->save();
        }

        return true;
    }

    public function loadSession(string $sessionId): ?Session
    {
        if (str_starts_with($sessionId, 'online_')) {
            // It's an online session. We need the user ID from the session ID.
            $parts = explode('_', $sessionId);
            $shopifyUserId = end($parts);

            $user = User::query()->where('shopify_user_id', $shopifyUserId)->with('shop')->first();
            if (!$user) {
                return null;
            }

            $shopifySession = new Session($sessionId, $user->shop->shop, true, $user->shop->state);
            $shopifySession->setAccessToken($user->shopify_access_token);
            $shopifySession->setExpires($user->shopify_token_expires_at);
            return $shopifySession;
        }

        // It's an offline session
        $shopName = str_replace('offline_', '', $sessionId);
        $shop = Shop::query()->where('shop', $shopName)->first();
        if (!$shop) {
            return null;
        }

        $shopifySession = new Session($sessionId, $shop->shop, false, $shop->state);
        $shopifySession->setScope($shop->scope);
        $shopifySession->setAccessToken($shop->access_token);
        return $shopifySession;
    }

    public function deleteSession(string $sessionId): bool
    {
        // We only really care about deleting online sessions here.
        // Deleting the session just means removing the token from the user.
        if (str_starts_with($sessionId, 'online_')) {
            $parts = explode('_', $sessionId);
            $shopifyUserId = end($parts);

            return User::query()
                ->where('shopify_user_id', $shopifyUserId)
                ->update(['shopify_access_token' => null]) > 0;
        }

        return false; // Cannot delete the main offline shop token this way.
    }
}
