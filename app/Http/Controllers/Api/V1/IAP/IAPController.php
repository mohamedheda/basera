<?php

namespace App\Http\Controllers\Api\V1\IAP;

use App\Http\Controllers\Controller;
use App\Http\Services\IAP\IAPSubscriptionService;
use Illuminate\Http\Request;

class IAPController extends Controller
{
    protected $iapService;

    public function __construct(IAPSubscriptionService $iapService)
    {
        $this->iapService = $iapService;
    }

    /**
     * Get products for specific platform
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProducts(Request $request)
    {
        $platform = $request->query('platform', 'all'); // google_play, apple_store, or all
        
        return $this->iapService->getProductsByPlatform($platform);
    }

    /**
     * Verify Google Play purchase
     * 
     * POST /api/v1/iap/google-verify
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyGooglePlayPurchase(Request $request)
    {
        $validated = $request->validate([
            'package_id' => 'required|integer|exists:subscription_packages,id',
            'product_id' => 'required|string',
            'purchase_token' => 'required|string',
            'order_id' => 'nullable|string',
        ]);

        $userId = auth('api')->id();

        return $this->iapService->verifyGooglePlayPurchase($userId, $validated);
    }

    /**
     * Verify Apple Store purchase
     * 
     * POST /api/v1/iap/apple-verify
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyAppleStorePurchase(Request $request)
    {
        $validated = $request->validate([
            'package_id' => 'required|integer|exists:subscription_packages,id',
            'product_id' => 'required|string',
            'receipt_data' => 'required|string',
        ]);

        $userId = auth('api')->id();

        return $this->iapService->verifyAppleStorePurchase($userId, $validated);
    }
}

