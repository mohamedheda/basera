<?php

namespace App\Http\Controllers\Dashboard\Home;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserSubscription;
use App\Models\InvestmentOpportunity;
use App\Models\RegistrationQuestion;
use App\Models\Manager;

class HomeController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $verifiedUsers = User::where('otp_verified', true)->count();

        $totalSubscriptions = UserSubscription::count();
        $activeSubscriptions = UserSubscription::where('status', 'active')
            ->where('end_date', '>=', now())
            ->count();
        $totalRevenue = UserSubscription::where('status', 'active')->sum('amount_paid');

        $totalOpportunities = InvestmentOpportunity::count();
        $halalOpportunities = InvestmentOpportunity::where('is_halal', true)->count();

        $totalQuestions = RegistrationQuestion::where('is_active', true)->count();
        $totalManagers = Manager::where('is_active', true)->count();

        $usersGrowth = $this->calculateGrowthPercentage(User::class);
        $subscriptionsGrowth = $this->calculateGrowthPercentage(UserSubscription::class);

        return view('dashboard.site.home.index', compact(
            'totalUsers',
            'activeUsers',
            'verifiedUsers',
            'totalSubscriptions',
            'activeSubscriptions',
            'totalRevenue',
            'totalOpportunities',
            'halalOpportunities',
            'totalQuestions',
            'totalManagers',
            'usersGrowth',
            'subscriptionsGrowth'
        ));
    }
    private function calculateGrowthPercentage($model)
    {
        $currentMonthCount = $model::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        $lastMonthCount = $model::whereYear('created_at', now()->subMonth()->year)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->count();

        if ($lastMonthCount == 0) {
            return $currentMonthCount > 0 ? 100 : 0;
        }

        return round((($currentMonthCount - $lastMonthCount) / $lastMonthCount) * 100, 1);
    }
}
