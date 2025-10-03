<?php

namespace App\Http\Controllers\Api\V1\Subscription;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Subscription\SubscribeRequest;
use App\Http\Resources\V1\Subscription\SubscriptionPackageResource;
use App\Http\Resources\V1\Subscription\UserSubscriptionResource;
use App\Http\Services\Api\V1\Subscription\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SubscriptionController extends Controller
{
    protected SubscriptionService $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * Get all subscription packages
     */
    public function index(): JsonResponse
    {
        try {
            $packages = $this->subscriptionService->getAllPackages();

            return response()->json([
                'success' => true,
                'data' => SubscriptionPackageResource::collection($packages)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch subscription packages',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get subscription package details
     */
    public function show($id): JsonResponse
    {
        try {
            $package = $this->subscriptionService->getPackageById($id);

            if (!$package) {
                return response()->json([
                    'success' => false,
                    'message' => 'Subscription package not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => new SubscriptionPackageResource($package)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch subscription package',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Subscribe user to a package
     */
    public function subscribe(SubscribeRequest $request): JsonResponse
    {
        try {
            /** @var \App\Models\User $user */
            $user = $request->user();
            $subscription = $this->subscriptionService->createSubscription(
                $user,
                $request->validated()
            );

            return response()->json([
                'success' => true,
                'message' => 'Subscription created successfully',
                'data' => new UserSubscriptionResource($subscription)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Get user's subscriptions
     */
    public function userSubscriptions(Request $request): JsonResponse
    {
        try {
            /** @var \App\Models\User $user */
            $user = $request->user();
            $subscriptions = $this->subscriptionService->getUserSubscriptions($user);

            return response()->json([
                'success' => true,
                'data' => UserSubscriptionResource::collection($subscriptions)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch subscriptions',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's active subscription
     */
    public function activeSubscription(Request $request): JsonResponse
    {
        try {
            /** @var \App\Models\User $user */
            $user = $request->user();
            $activeSubscription = $this->subscriptionService->getActiveSubscription($user);

            if (!$activeSubscription) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active subscription found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => new UserSubscriptionResource($activeSubscription)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch active subscription',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cancel user's subscription
     */
    public function cancelSubscription(Request $request): JsonResponse
    {
        try {
            /** @var \App\Models\User $user */
            $user = $request->user();
            $this->subscriptionService->cancelSubscription($user);

            return response()->json([
                'success' => true,
                'message' => 'Subscription cancelled successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Get subscription statistics
     */
    public function statistics(): JsonResponse
    {
        try {
            $stats = $this->subscriptionService->getStatistics();

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
