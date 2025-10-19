<?php

namespace App\Http\Services\IAP;

use App\Models\SubscriptionPackage;
use App\Models\UserSubscription;
use App\Http\Helpers\Http;
use App\Http\Resources\V1\SubscriptionPackageResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function App\Http\Helpers\responseSuccess;
use function App\Http\Helpers\responseFail;

class IAPSubscriptionService
{
    protected $googlePlayService;
    protected $appleStoreService;

    public function __construct(
        GooglePlayBillingService $googlePlayService,
        AppleStoreBillingService $appleStoreService
    ) {
        $this->googlePlayService = $googlePlayService;
        $this->appleStoreService = $appleStoreService;
    }

    /**
     * Get available products for specific platform
     */
    public function getProductsByPlatform($platform)
    {
        try {
            $packages = SubscriptionPackage::where('is_active', true)
                ->orderBy('price', 'asc')
                ->get();

            // Filter packages based on platform
            $filteredPackages = $packages->filter(function ($package) use ($platform) {
                if ($platform === 'google_play') {
                    return !empty($package->google_product_id);
                } elseif ($platform === 'apple_store') {
                    return !empty($package->apple_product_id);
                }
                return true;
            });

            return responseSuccess(
                message: __('messages.Packages retrieved successfully'),
                data: SubscriptionPackageResource::collection($filteredPackages)
            );

        } catch (\Exception $e) {
            Log::error('Failed to get IAP products', [
                'platform' => $platform,
                'error' => $e->getMessage(),
            ]);

            return responseFail(
                status: Http::INTERNAL_SERVER_ERROR,
                message: __('messages.Failed to retrieve packages')
            );
        }
    }

    /**
     * Verify and process Google Play purchase
     */
    public function verifyGooglePlayPurchase($userId, $data)
    {
        try {
            DB::beginTransaction();

            // Validate required fields
            if (empty($data['package_id']) || empty($data['product_id']) || empty($data['purchase_token'])) {
                return responseFail(
                    status: Http::BAD_REQUEST,
                    message: __('messages.Missing required fields')
                );
            }

            // Check if package exists
            $package = SubscriptionPackage::find($data['package_id']);
            if (!$package) {
                return responseFail(
                    status: Http::NOT_FOUND,
                    message: __('messages.Package not found')
                );
            }

            // Check if product ID matches
            if ($package->google_product_id !== $data['product_id']) {
                return responseFail(
                    status: Http::BAD_REQUEST,
                    message: __('messages.Product ID mismatch')
                );
            }

            // Check if purchase token already used
            $existingSubscription = UserSubscription::where('google_purchase_token', $data['purchase_token'])->first();
            if ($existingSubscription) {
                return responseFail(
                    status: Http::BAD_REQUEST,
                    message: __('messages.Purchase token already used')
                );
            }

            // Verify with Google Play
            $verification = $this->googlePlayService->verifySubscription(
                $data['product_id'],
                $data['purchase_token']
            );

            if (!$verification['valid']) {
                return responseFail(
                    status: Http::BAD_REQUEST,
                    message: __('messages.Invalid purchase') . ': ' . ($verification['error'] ?? 'Unknown error')
                );
            }

            // Calculate dates
            $startDate = now();
            $endDate = isset($verification['expiry_time']) 
                ? date('Y-m-d', $verification['expiry_time'])
                : $startDate->copy()->addMonths($package->duration_months);

            // Cancel existing active subscriptions
            UserSubscription::where('user_id', $userId)
                ->where('status', 'active')
                ->update(['status' => 'cancelled']);

            // Create subscription
            $subscription = UserSubscription::create([
                'user_id' => $userId,
                'subscription_package_id' => $package->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'amount_paid' => $package->price,
                'status' => 'active',
                'payment_method' => 'google_play',
                'transaction_id' => $data['order_id'] ?? null,
                'payment_platform' => 'google_play',
                'google_product_id' => $data['product_id'],
                'google_purchase_token' => $data['purchase_token'],
                'google_order_id' => $verification['order_id'] ?? $data['order_id'] ?? null,
                'google_purchase_state' => $verification['purchase_state'] ?? 'purchased',
                'google_acknowledged' => $verification['acknowledged'] ?? false,
                'receipt_data' => $verification['data'] ?? null,
                'auto_renew' => $verification['auto_renewing'] ?? true,
                'last_verified_at' => now(),
            ]);

            // Acknowledge purchase if not already acknowledged
            if (!$verification['acknowledged']) {
                $this->googlePlayService->acknowledgeSubscription(
                    $data['product_id'],
                    $data['purchase_token']
                );

                $subscription->update(['google_acknowledged' => true]);
            }

            DB::commit();

            return responseSuccess(
                message: __('messages.Subscription activated successfully'),
                data: [
                    'subscription' => $subscription,
                    'package' => $package,
                ]
            );

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Google Play purchase verification failed', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return responseFail(
                status: Http::INTERNAL_SERVER_ERROR,
                message: __('messages.Failed to process purchase')
            );
        }
    }

    /**
     * Verify and process Apple Store purchase
     */
    public function verifyAppleStorePurchase($userId, $data)
    {
        try {
            DB::beginTransaction();

            // Validate required fields
            if (empty($data['package_id']) || empty($data['product_id']) || empty($data['receipt_data'])) {
                return responseFail(
                    status: Http::BAD_REQUEST,
                    message: __('messages.Missing required fields')
                );
            }

            // Check if package exists
            $package = SubscriptionPackage::find($data['package_id']);
            if (!$package) {
                return responseFail(
                    status: Http::NOT_FOUND,
                    message: __('messages.Package not found')
                );
            }

            // Check if product ID matches
            if ($package->apple_product_id !== $data['product_id']) {
                return responseFail(
                    status: Http::BAD_REQUEST,
                    message: __('messages.Product ID mismatch')
                );
            }

            // Verify with Apple Store
            $verification = $this->appleStoreService->verifySubscription(
                $data['receipt_data'],
                $data['product_id']
            );

            if (!$verification['valid']) {
                return responseFail(
                    status: Http::BAD_REQUEST,
                    message: __('messages.Invalid purchase') . ': ' . ($verification['error'] ?? 'Unknown error')
                );
            }

            // Check if transaction already exists
            $existingSubscription = UserSubscription::where('apple_original_transaction_id', $verification['original_transaction_id'])->first();
            if ($existingSubscription) {
                return responseFail(
                    status: Http::BAD_REQUEST,
                    message: __('messages.Purchase already processed')
                );
            }

            // Calculate dates
            $startDate = isset($verification['purchase_date_ms'])
                ? date('Y-m-d', intval($verification['purchase_date_ms'] / 1000))
                : now();
            
            $endDate = isset($verification['expires_date_ms'])
                ? date('Y-m-d', intval($verification['expires_date_ms'] / 1000))
                : now()->addMonths($package->duration_months);

            // Cancel existing active subscriptions
            UserSubscription::where('user_id', $userId)
                ->where('status', 'active')
                ->update(['status' => 'cancelled']);

            // Create subscription
            $subscription = UserSubscription::create([
                'user_id' => $userId,
                'subscription_package_id' => $package->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'amount_paid' => $package->price,
                'status' => 'active',
                'payment_method' => 'apple_store',
                'transaction_id' => $verification['transaction_id'] ?? null,
                'payment_platform' => 'apple_store',
                'apple_product_id' => $data['product_id'],
                'apple_transaction_id' => $verification['transaction_id'] ?? null,
                'apple_original_transaction_id' => $verification['original_transaction_id'] ?? null,
                'apple_receipt' => $data['receipt_data'],
                'apple_purchase_state' => 'purchased',
                'receipt_data' => $verification['data'] ?? null,
                'auto_renew' => $verification['auto_renew_status'] ?? true,
                'last_verified_at' => now(),
            ]);

            DB::commit();

            return responseSuccess(
                message: __('messages.Subscription activated successfully'),
                data: [
                    'subscription' => $subscription,
                    'package' => $package,
                ]
            );

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Apple Store purchase verification failed', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return responseFail(
                status: Http::INTERNAL_SERVER_ERROR,
                message: __('messages.Failed to process purchase')
            );
        }
    }
}

