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
        // Add IAP fields to subscription_packages
        Schema::table('subscription_packages', function (Blueprint $table) {
            $table->string('google_product_id')->nullable()->unique()->after('features');
            $table->string('apple_product_id')->nullable()->unique()->after('google_product_id');
        });

        // Add IAP fields to user_subscriptions
        Schema::table('user_subscriptions', function (Blueprint $table) {
            $table->enum('payment_platform', ['card', 'google_play', 'apple_store'])->default('card')->after('payment_method');
            
            // Google Play fields
            $table->string('google_product_id')->nullable()->after('payment_platform');
            $table->text('google_purchase_token')->nullable()->after('google_product_id');
            $table->string('google_order_id')->nullable()->after('google_purchase_token');
            $table->enum('google_purchase_state', ['pending', 'purchased', 'cancelled', 'refunded'])->nullable()->after('google_order_id');
            $table->boolean('google_acknowledged')->default(false)->after('google_purchase_state');
            
            // Apple Store fields
            $table->string('apple_product_id')->nullable()->after('google_acknowledged');
            $table->text('apple_transaction_id')->nullable()->after('apple_product_id');
            $table->text('apple_original_transaction_id')->nullable()->after('apple_transaction_id');
            $table->string('apple_receipt')->nullable()->after('apple_original_transaction_id');
            $table->enum('apple_purchase_state', ['pending', 'purchased', 'cancelled', 'refunded'])->nullable()->after('apple_receipt');
            
            // Common IAP fields
            $table->json('receipt_data')->nullable()->after('apple_purchase_state');
            $table->boolean('auto_renew')->default(true)->after('receipt_data');
            $table->timestamp('last_verified_at')->nullable()->after('auto_renew');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_packages', function (Blueprint $table) {
            $table->dropColumn(['google_product_id', 'apple_product_id']);
        });

        Schema::table('user_subscriptions', function (Blueprint $table) {
            $table->dropColumn([
                'payment_platform',
                'google_product_id',
                'google_purchase_token',
                'google_order_id',
                'google_purchase_state',
                'google_acknowledged',
                'apple_product_id',
                'apple_transaction_id',
                'apple_original_transaction_id',
                'apple_receipt',
                'apple_purchase_state',
                'receipt_data',
                'auto_renew',
                'last_verified_at',
            ]);
        });
    }
};
