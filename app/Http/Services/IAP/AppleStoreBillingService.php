<?php

namespace App\Http\Services\IAP;

use App\Models\UserSubscription;
use App\Models\SubscriptionPackage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class AppleStoreBillingService
{
    private $sharedSecret;
    private $verifyUrl;
    private $sandboxUrl = 'https://sandbox.itunes.apple.com/verifyReceipt';
    private $productionUrl = 'https://buy.itunes.apple.com/verifyReceipt';

    public function __construct()
    {
        $this->sharedSecret = config('services.apple_store.shared_secret');
        $this->verifyUrl = config('app.env') === 'production' 
            ? $this->productionUrl 
            : $this->sandboxUrl;
    }

    /**
     * Verify receipt with Apple Store
     */
    public function verifyReceipt($receiptData, $excludeOldTransactions = true)
    {
        try {
            $requestBody = [
                'receipt-data' => $receiptData,
                'password' => $this->sharedSecret,
                'exclude-old-transactions' => $excludeOldTransactions,
            ];

            // Try production first
            $response = Http::post($this->productionUrl, $requestBody);
            $result = $response->json();

            // If sandbox receipt in production, try sandbox
            if (isset($result['status']) && $result['status'] === 21007) {
                $response = Http::post($this->sandboxUrl, $requestBody);
                $result = $response->json();
            }

            if (!isset($result['status']) || $result['status'] !== 0) {
                Log::error('Apple Store verification failed', [
                    'status' => $result['status'] ?? 'unknown',
                    'error' => $this->getStatusMessage($result['status'] ?? -1),
                ]);

                return ['valid' => false, 'error' => $this->getStatusMessage($result['status'] ?? -1)];
            }

            // Parse latest receipt info
            $latestReceiptInfo = $result['latest_receipt_info'][0] ?? null;
            
            if (!$latestReceiptInfo) {
                return ['valid' => false, 'error' => 'No receipt info found'];
            }

            return [
                'valid' => true,
                'data' => $result,
                'transaction_id' => $latestReceiptInfo['transaction_id'] ?? null,
                'original_transaction_id' => $latestReceiptInfo['original_transaction_id'] ?? null,
                'product_id' => $latestReceiptInfo['product_id'] ?? null,
                'purchase_date_ms' => $latestReceiptInfo['purchase_date_ms'] ?? null,
                'expires_date_ms' => $latestReceiptInfo['expires_date_ms'] ?? null,
                'is_trial_period' => ($latestReceiptInfo['is_trial_period'] ?? 'false') === 'true',
                'cancellation_date' => $latestReceiptInfo['cancellation_date'] ?? null,
                'auto_renew_status' => isset($result['pending_renewal_info'][0]['auto_renew_status'])
                    ? $result['pending_renewal_info'][0]['auto_renew_status'] === '1'
                    : true,
            ];

        } catch (\Exception $e) {
            Log::error('Apple Store verification exception', [
                'message' => $e->getMessage(),
            ]);

            return ['valid' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Verify subscription purchase
     */
    public function verifySubscription($receiptData, $productId)
    {
        $verification = $this->verifyReceipt($receiptData);

        if (!$verification['valid']) {
            return $verification;
        }

        // Check if product matches
        if ($verification['product_id'] !== $productId) {
            return ['valid' => false, 'error' => 'Product ID mismatch'];
        }

        return $verification;
    }

    /**
     * Handle Server-to-Server notification
     */
    public function handleNotification($notificationData)
    {
        try {
            $notificationType = $notificationData['notification_type'] ?? null;
            $latestReceipt = $notificationData['latest_receipt'] ?? null;
            $latestReceiptInfo = $notificationData['latest_receipt_info'] ?? null;

            if (!$notificationType || !$latestReceiptInfo) {
                Log::error('Invalid Apple notification data');
                return false;
            }

            $originalTransactionId = $latestReceiptInfo['original_transaction_id'] ?? null;

            // Find subscription by original transaction ID
            $subscription = UserSubscription::where('apple_original_transaction_id', $originalTransactionId)->first();

            if (!$subscription) {
                Log::warning('Subscription not found for Apple notification', [
                    'original_transaction_id' => $originalTransactionId,
                ]);
                return false;
            }

            // Handle different notification types
            switch ($notificationType) {
                case 'INITIAL_BUY':
                case 'DID_RENEW':
                    $this->handleRenewal($subscription, $latestReceipt, $latestReceiptInfo);
                    break;

                case 'DID_CHANGE_RENEWAL_STATUS':
                    $autoRenewStatus = $notificationData['auto_renew_status'] ?? 'false';
                    $subscription->update([
                        'auto_renew' => $autoRenewStatus === 'true',
                    ]);
                    break;

                case 'CANCEL':
                    $this->handleCancellation($subscription, $latestReceiptInfo);
                    break;

                case 'DID_FAIL_TO_RENEW':
                    // Keep active for grace period
                    Log::warning('Apple subscription failed to renew', [
                        'subscription_id' => $subscription->id,
                    ]);
                    break;

                case 'REFUND':
                    $subscription->update([
                        'status' => 'cancelled',
                        'apple_purchase_state' => 'refunded',
                    ]);
                    break;

                case 'REVOKE':
                    $subscription->update([
                        'status' => 'cancelled',
                        'apple_purchase_state' => 'refunded',
                    ]);
                    break;
            }

            return true;

        } catch (\Exception $e) {
            Log::error('Error handling Apple notification', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return false;
        }
    }

    private function handleRenewal($subscription, $receipt, $receiptInfo)
    {
        $expiresDate = isset($receiptInfo['expires_date_ms']) 
            ? date('Y-m-d', intval($receiptInfo['expires_date_ms'] / 1000))
            : null;

        $subscription->update([
            'apple_transaction_id' => $receiptInfo['transaction_id'] ?? $subscription->apple_transaction_id,
            'apple_receipt' => $receipt ?? $subscription->apple_receipt,
            'end_date' => $expiresDate,
            'status' => 'active',
            'apple_purchase_state' => 'purchased',
            'last_verified_at' => now(),
        ]);
    }

    private function handleCancellation($subscription, $receiptInfo)
    {
        $cancellationDate = $receiptInfo['cancellation_date_ms'] ?? null;

        $subscription->update([
            'auto_renew' => false,
            'apple_purchase_state' => 'cancelled',
            'status' => $cancellationDate ? 'cancelled' : 'active', // If has cancellation date, mark as cancelled
        ]);
    }

    /**
     * Get human-readable status message
     */
    private function getStatusMessage($status)
    {
        $messages = [
            0 => 'Valid receipt',
            21000 => 'The App Store could not read the JSON object you provided.',
            21002 => 'The data in the receipt-data property was malformed or missing.',
            21003 => 'The receipt could not be authenticated.',
            21004 => 'The shared secret you provided does not match the shared secret on file for your account.',
            21005 => 'The receipt server is not currently available.',
            21006 => 'This receipt is valid but the subscription has expired.',
            21007 => 'This receipt is from the test environment, but it was sent to the production environment for verification.',
            21008 => 'This receipt is from the production environment, but it was sent to the test environment for verification.',
            21009 => 'Internal data access error.',
            21010 => 'The user account cannot be found or has been deleted.',
        ];

        return $messages[$status] ?? 'Unknown error';
    }

    /**
     * Check if subscription is still valid
     */
    public function isSubscriptionValid($expiresDateMs)
    {
        if (!$expiresDateMs) {
            return false;
        }

        $expiresDate = intval($expiresDateMs / 1000);
        return time() < $expiresDate;
    }
}

