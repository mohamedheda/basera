<?php

namespace App\Http\Services\Dashboard\UserSubscription;

use App\Http\Helpers\Http;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\DB;

use function App\Http\Helpers\responseFail;
use function App\Http\Helpers\responseSuccess;

class UserSubscriptionService
{
    public function index()
    {
        $subscriptions = UserSubscription::with(['user', 'subscriptionPackage'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $stats = [
            'total' => UserSubscription::count(),
            'active' => UserSubscription::where('status', 'active')
                ->where('end_date', '>=', now())
                ->count(),
            'expired' => UserSubscription::where('end_date', '<', now())->count(),
            'cancelled' => UserSubscription::where('status', 'cancelled')->count(),
            'total_revenue' => UserSubscription::where('status', 'active')->sum('amount_paid'),
        ];

        return view('dashboard.site.subscriptions.index', compact('subscriptions', 'stats'));
    }

    public function show($id)
    {
        $subscription = UserSubscription::with(['user', 'subscriptionPackage'])->findOrFail($id);

        return view('dashboard.site.subscriptions.show', compact('subscription'));
    }

    public function updateStatus($id, $status)
    {
        try {
            DB::beginTransaction();

            $subscription = UserSubscription::findOrFail($id);

            if (!in_array($status, ['active', 'cancelled', 'expired'])) {
                return responseFail(Http::BAD_REQUEST, __('messages.Invalid status'));
            }

            $subscription->update(['status' => $status]);

            DB::commit();

            return responseSuccess(Http::OK, __('messages.updated_successfully'), true);
        } catch (\Exception $e) {
            DB::rollBack();
            return responseFail(Http::BAD_REQUEST, __('messages.Something went wrong'));
        }
    }

    public function destroy($id)
    {
        try {
            $subscription = UserSubscription::findOrFail($id);
            $subscription->delete();

            return responseSuccess(Http::OK, __('messages.deleted_successfully'), true);
        } catch (\Exception $e) {
            return responseFail(Http::BAD_REQUEST, __('messages.Something went wrong'));
        }
    }
}
