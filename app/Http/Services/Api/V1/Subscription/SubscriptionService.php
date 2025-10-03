<?php

namespace App\Http\Services\Api\V1\Subscription;

use App\Models\SubscriptionPackage;
use App\Models\UserSubscription;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;

class SubscriptionService
{
    /**
     * Get all active subscription packages
     */
    public function getAllPackages()
    {
        return SubscriptionPackage::where('is_active', true)
            ->orderBy('duration_months', 'asc')
            ->get();
    }

    /**
     * Get single package by ID
     */
    public function getPackageById(int $id)
    {
        return SubscriptionPackage::where('id', $id)
            ->where('is_active', true)
            ->first();
    }

    /**
     * Create subscription for user
     */
    public function createSubscription(User $user, array $data)
    {
        DB::beginTransaction();
        try {
            $package = SubscriptionPackage::findOrFail($data['package_id']);

            // Check if user already has an active subscription
            if ($user->activeSubscription) {
                throw new Exception('You already have an active subscription');
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
                'payment_method' => $data['payment_method'],
                'transaction_id' => $data['transaction_id'] ?? null,
            ]);

            $subscription->load('subscriptionPackage');

            DB::commit();
            return $subscription;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Get user's all subscriptions
     */
    public function getUserSubscriptions(User $user, int $perPage = 10)
    {
        return $user->subscriptions()
            ->with('subscriptionPackage')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get user's active subscription
     */
    public function getActiveSubscription(User $user)
    {
        $activeSubscription = $user->activeSubscription;

        if ($activeSubscription) {
            $activeSubscription->load('subscriptionPackage');
        }

        return $activeSubscription;
    }

    /**
     * Cancel user's active subscription
     */
    public function cancelSubscription(User $user)
    {
        $activeSubscription = $user->activeSubscription;

        if (!$activeSubscription) {
            throw new Exception('No active subscription found');
        }

        $activeSubscription->update(['status' => 'cancelled']);

        return $activeSubscription;
    }

    /**
     * Get subscription statistics
     */
    public function getStatistics()
    {
        return [
            'total_packages' => SubscriptionPackage::where('is_active', true)->count(),
            'total_subscriptions' => UserSubscription::count(),
            'active_subscriptions' => UserSubscription::where('status', 'active')
                ->where('end_date', '>=', now())
                ->count(),
            'expired_subscriptions' => UserSubscription::where('end_date', '<', now())->count(),
            'cancelled_subscriptions' => UserSubscription::where('status', 'cancelled')->count(),
            'total_revenue' => UserSubscription::where('status', 'active')->sum('amount_paid'),
            'popular_packages' => SubscriptionPackage::where('is_active', true)
                ->where('is_popular', true)
                ->get(),
        ];
    }
}
