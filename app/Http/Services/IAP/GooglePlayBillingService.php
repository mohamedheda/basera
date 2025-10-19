<?php

namespace App\Http\Services\IAP;

use App\Models\UserSubscription;
use App\Models\SubscriptionPackage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class GooglePlayBillingService
{
    private $packageName;
    private $serviceAccountPath;

    public function __construct()
    {
        $this->packageName = config('services.google_play.package_name');
        $this->serviceAccountPath = storage_path(config('services.google_play.service_account_path'));
    }

    /**
     * Verify subscription purchase with Google Play API
     */
    public function verifySubscription($productId, $purchaseToken)
    {
        try {
            // Get access token
            $accessToken = $this->getAccessToken();

            // Call Google Play Developer API
            $url = "https://androidpublisher.googleapis.com/androidpublisher/v3/applications/{$this->packageName}/purchases/subscriptions/{$productId}/tokens/{$purchaseToken}";

            $response = Http::withToken($accessToken)->get($url);

            if ($response->successful()) {
                $data = $response->json();
                
                return [
                    'valid' => true,
                    'data' => $data,
                    'order_id' => $data['orderId'] ?? null,
                    'purchase_state' => $this->mapPurchaseState($data['paymentState'] ?? 0),
                    'expiry_time' => isset($data['expiryTimeMillis']) ? intval($data['expiryTimeMillis'] / 1000) : null,
                    'auto_renewing' => $data['autoRenewing'] ?? false,
                    'acknowledged' => $data['acknowledgementState'] ?? 0 === 1,
                ];
            }

            Log::error('Google Play verification failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return ['valid' => false, 'error' => 'Verification failed'];

        } catch (\Exception $e) {
            Log::error('Google Play verification exception', [
                'message' => $e->getMessage(),
                'product_id' => $productId,
            ]);

            return ['valid' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Acknowledge subscription purchase
     */
    public function acknowledgeSubscription($productId, $purchaseToken)
    {
        try {
            $accessToken = $this->getAccessToken();

            $url = "https://androidpublisher.googleapis.com/androidpublisher/v3/applications/{$this->packageName}/purchases/subscriptions/{$productId}/tokens/{$purchaseToken}:acknowledge";

            $response = Http::withToken($accessToken)->post($url);

            return $response->successful();

        } catch (\Exception $e) {
            Log::error('Google Play acknowledgment failed', [
                'message' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Cancel subscription
     */
    public function cancelSubscription($productId, $token)
    {
        try {
            $accessToken = $this->getAccessToken();

            $url = "https://androidpublisher.googleapis.com/androidpublisher/v3/applications/{$this->packageName}/purchases/subscriptions/{$productId}/tokens/{$token}:cancel";

            $response = Http::withToken($accessToken)->post($url);

            return $response->successful();

        } catch (\Exception $e) {
            Log::error('Google Play cancellation failed', [
                'message' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Get access token from service account
     */
    private function getAccessToken()
    {
        if (!file_exists($this->serviceAccountPath)) {
            throw new \Exception('Google service account file not found');
        }

        $client = new \Google_Client();
        $client->setAuthConfig($this->serviceAccountPath);
        $client->addScope('https://www.googleapis.com/auth/androidpublisher');
        
        $token = $client->fetchAccessTokenWithAssertion();
        
        if (isset($token['access_token'])) {
            return $token['access_token'];
        }

        throw new \Exception('Failed to get access token');
    }

    /**
     * Map Google Play purchase state to our enum
     */
    private function mapPurchaseState($state)
    {
        return match ($state) {
            0 => 'pending',
            1 => 'purchased',
            2 => 'cancelled',
            default => 'pending',
        };
    }

    /**
     * Handle Real-time Developer Notification
     */
    public function handleNotification($notificationData)
    {
        try {
            $message = $notificationData['message'] ?? [];
            $data = json_decode(base64_decode($message['data'] ?? ''), true);

            if (!$data) {
                Log::error('Invalid Google Play notification data');
                return false;
            }

            $subscriptionNotification = $data['subscriptionNotification'] ?? null;

            if (!$subscriptionNotification) {
                return false;
            }

            $notificationType = $subscriptionNotification['notificationType'];
            $purchaseToken = $subscriptionNotification['purchaseToken'];
            $productId = $data['subscriptionNotification']['subscriptionId'] ?? null;

            // Find subscription by purchase token
            $subscription = UserSubscription::where('google_purchase_token', $purchaseToken)->first();

            if (!$subscription) {
                Log::warning('Subscription not found for notification', [
                    'purchase_token' => $purchaseToken,
                ]);
                return false;
            }

            // Handle different notification types
            switch ($notificationType) {
                case 1: // SUBSCRIPTION_RECOVERED
                case 2: // SUBSCRIPTION_RENEWED
                    $this->handleRenewal($subscription, $productId, $purchaseToken);
                    break;

                case 3: // SUBSCRIPTION_CANCELED
                    $this->handleCancellation($subscription);
                    break;

                case 4: // SUBSCRIPTION_PURCHASED
                    $this->handlePurchase($subscription, $productId, $purchaseToken);
                    break;

                case 5: // SUBSCRIPTION_ON_HOLD
                    $subscription->update(['status' => 'cancelled']);
                    break;

                case 6: // SUBSCRIPTION_IN_GRACE_PERIOD
                    // Keep active but log warning
                    Log::warning('Subscription in grace period', [
                        'subscription_id' => $subscription->id,
                    ]);
                    break;

                case 12: // SUBSCRIPTION_EXPIRED
                    $subscription->update(['status' => 'expired']);
                    break;

                case 13: // SUBSCRIPTION_REVOKED
                    $subscription->update([
                        'status' => 'cancelled',
                        'google_purchase_state' => 'refunded',
                    ]);
                    break;
            }

            return true;

        } catch (\Exception $e) {
            Log::error('Error handling Google Play notification', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return false;
        }
    }

    private function handleRenewal($subscription, $productId, $purchaseToken)
    {
        $verification = $this->verifySubscription($productId, $purchaseToken);

        if ($verification['valid']) {
            $expiryTime = $verification['expiry_time'];
            
            $subscription->update([
                'end_date' => date('Y-m-d', $expiryTime),
                'status' => 'active',
                'google_purchase_state' => 'purchased',
                'last_verified_at' => now(),
            ]);
        }
    }

    private function handleCancellation($subscription)
    {
        $subscription->update([
            'auto_renew' => false,
            'google_purchase_state' => 'cancelled',
        ]);
    }

    private function handlePurchase($subscription, $productId, $purchaseToken)
    {
        $verification = $this->verifySubscription($productId, $purchaseToken);

        if ($verification['valid']) {
            $expiryTime = $verification['expiry_time'];
            
            $subscription->update([
                'start_date' => now(),
                'end_date' => date('Y-m-d', $expiryTime),
                'status' => 'active',
                'google_purchase_state' => 'purchased',
                'google_acknowledged' => $verification['acknowledged'],
                'last_verified_at' => now(),
            ]);
        }
    }
}

