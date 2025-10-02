<?php

namespace App\Http\Controllers\Api\V1\Subscription;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPackage;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    /**
     * Get all subscription packages
     */
    public function index()
    {
        try {
            $packages = SubscriptionPackage::where('is_active', true)
                ->orderBy('duration_months', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $packages
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
    public function show($id)
    {
        try {
            $package = SubscriptionPackage::where('id', $id)
                ->where('is_active', true)
                ->first();

            if (!$package) {
                return response()->json([
                    'success' => false,
                    'message' => 'Subscription package not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $package
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
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'package_id' => 'required|exists:subscription_packages,id',
            'payment_method' => 'required|string|max:255',
            'transaction_id' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = $request->user();
            $package = SubscriptionPackage::findOrFail($request->package_id);

            // Check if user already has an active subscription
            $activeSubscription = $user->activeSubscription;
            if ($activeSubscription) {
                return response()->json([
                    'success' => false,
                    'message' => 'You already have an active subscription'
                ], 400);
            }

            // Calculate subscription dates
            $startDate = now();
            $endDate = $startDate->copy()->addMonths($package->duration_months);

            // Create subscription
            $subscription = UserSubscription::create([
                'user_id' => $user->id,
                'subscription_package_id' => $package->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'amount_paid' => $package->price,
                'status' => 'active',
                'payment_method' => $request->payment_method,
                'transaction_id' => $request->transaction_id,
            ]);

            $subscription->load('subscriptionPackage');

            return response()->json([
                'success' => true,
                'message' => 'Subscription created successfully',
                'data' => $subscription
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Subscription failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's subscriptions
     */
    public function userSubscriptions(Request $request)
    {
        try {
            $user = $request->user();
            $subscriptions = $user->subscriptions()
                ->with('subscriptionPackage')
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return response()->json([
                'success' => true,
                'data' => $subscriptions
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
    public function activeSubscription(Request $request)
    {
        try {
            $user = $request->user();
            $activeSubscription = $user->activeSubscription;

            if (!$activeSubscription) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active subscription found'
                ], 404);
            }

            $activeSubscription->load('subscriptionPackage');

            return response()->json([
                'success' => true,
                'data' => $activeSubscription
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
    public function cancelSubscription(Request $request)
    {
        try {
            $user = $request->user();
            $activeSubscription = $user->activeSubscription;

            if (!$activeSubscription) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active subscription found'
                ], 404);
            }

            $activeSubscription->update(['status' => 'cancelled']);

            return response()->json([
                'success' => true,
                'message' => 'Subscription cancelled successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel subscription',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get subscription statistics
     */
    public function statistics()
    {
        try {
            $stats = [
                'total_packages' => SubscriptionPackage::where('is_active', true)->count(),
                'total_subscriptions' => UserSubscription::count(),
                'active_subscriptions' => UserSubscription::where('status', 'active')
                    ->where('end_date', '>=', now())
                    ->count(),
                'popular_packages' => SubscriptionPackage::where('is_active', true)
                    ->where('is_popular', true)
                    ->get(),
            ];

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
