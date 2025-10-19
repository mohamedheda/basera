<?php

namespace App\Http\Controllers\Api\V1\IAP;

use App\Http\Controllers\Controller;
use App\Http\Services\IAP\GooglePlayBillingService;
use App\Http\Services\IAP\AppleStoreBillingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
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
     * Handle Google Play Real-time Developer Notification
     * 
     * POST /api/v1/webhooks/google-play
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function googlePlayWebhook(Request $request)
    {
        try {
            Log::info('Google Play webhook received', [
                'data' => $request->all(),
            ]);

            $data = $request->all();

            // Process notification
            $result = $this->googlePlayService->handleNotification($data);

            if ($result) {
                return response()->json(['status' => 'success'], 200);
            }

            return response()->json(['status' => 'failed'], 400);

        } catch (\Exception $e) {
            Log::error('Google Play webhook error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['status' => 'error'], 500);
        }
    }

    /**
     * Handle Apple Store Server-to-Server Notification
     * 
     * POST /api/v1/webhooks/apple-store
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function appleStoreWebhook(Request $request)
    {
        try {
            Log::info('Apple Store webhook received', [
                'data' => $request->all(),
            ]);

            $data = $request->all();

            // Process notification
            $result = $this->appleStoreService->handleNotification($data);

            if ($result) {
                return response()->json(['status' => 'success'], 200);
            }

            return response()->json(['status' => 'failed'], 400);

        } catch (\Exception $e) {
            Log::error('Apple Store webhook error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['status' => 'error'], 500);
        }
    }
}

