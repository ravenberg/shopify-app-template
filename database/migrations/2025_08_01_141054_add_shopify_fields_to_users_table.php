<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // The user's associated shop
            $table->foreignId('shop_id')->nullable()->constrained()->cascadeOnDelete();

            // Shopify's ID for the user
            $table->bigInteger('shopify_user_id')->unique()->nullable();

            // The temporary ONLINE token and its expiry
            $table->text('shopify_access_token')->nullable(); // Encrypted
            $table->timestamp('shopify_token_expires_at')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['shop_id']);
            $table->dropColumn([
                'shop_id',
                'shopify_user_id',
                'shopify_access_token',
                'shopify_token_expires_at'
            ]);
        });
    }
};
