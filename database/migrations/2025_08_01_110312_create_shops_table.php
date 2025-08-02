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
        // One record per installed shop. Stores the Offline token
        Schema::create('shops', function (Blueprint $table) {
            $table->id();

            $table->string('shop')
                ->unique()
                ->comment('my-store.myshopify.com');
            $table->string('state')
                ->nullable()
                ->comment('for OAuth');
            $table->string('scope')
                ->comment('The API scopes');
            $table->text('access_token')
                ->comment('The permanent offline token (encrypted)');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
