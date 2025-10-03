<?php

namespace App\Http\Services\Api\V1\User;

use App\Http\Helpers\Http;
use App\Models\User;
use App\Models\RiskAssessment;
use App\Http\Resources\V1\User\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use function App\Http\Helpers\responseSuccess;
use function App\Http\Helpers\responseFail;

class UserService
{
    public function register($request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => Hash::make($data['password']),
                'id_number' => $data['id_number'],
                'date_of_birth' => $data['date_of_birth'],
                'marital_status' => $data['marital_status'],
                'family_members_count' => $data['family_members_count'],
                'education_level' => $data['education_level'],
                'annual_income' => $data['annual_income'],
                'total_savings' => $data['total_savings'],
                'bank_id' => $data['bank_id'],
                'profile_completed' => true,
            ]);

            $riskAssessment = RiskAssessment::create([
                'user_id' => $user->id,
                'has_investment_experience' => $data['has_investment_experience'],
                'willing_to_risk_capital' => $data['willing_to_risk_capital'],
                'has_stable_income' => $data['has_stable_income'],
                'plans_short_term_withdrawal' => $data['plans_short_term_withdrawal'],
                'prefers_high_risk_high_return' => $data['prefers_high_risk_high_return'],
                'consults_financial_advisor' => $data['consults_financial_advisor'],
            ]);

            $riskAssessment->calculateRiskScore()->save();

            $token = $user->token();
            $user->load('bank');

            DB::commit();

            return responseSuccess(
                status: Http::CREATED,
                message: __('messages.User registered successfully'),
                data: [
                    'user' => new UserResource($user, false),
                    'risk_assessment' => $riskAssessment,
                    'token' => $token,
                ]
            );
        } catch (\Exception $e) {
            DB::rollBack();

            return responseFail(
                status: Http::INTERNAL_SERVER_ERROR,
                message: __('messages.Registration failed'),
                data: $e->getMessage()
            );
        }
    }

    public function getProfile($user)
    {
        try {
            $user->load(['riskAssessment', 'bank']);

            return responseSuccess(
                message: __('messages.Profile retrieved successfully'),
                data: [
                    'user' => new UserResource($user, false),
                    'risk_assessment' => $user->riskAssessment,
                ]
            );
        } catch (\Exception $e) {
            return responseFail(
                status: Http::INTERNAL_SERVER_ERROR,
                message: __('messages.Failed to retrieve profile'),
                data: $e->getMessage()
            );
        }
    }

    public function updateProfile($request, $user)
    {
        try {
            $data = $request->validated();

            $user->update($data);
            $user->load('bank');

            return responseSuccess(
                message: __('messages.Profile updated successfully'),
                data: new UserResource($user, false)
            );
        } catch (\Exception $e) {
            return responseFail(
                status: Http::INTERNAL_SERVER_ERROR,
                message: __('messages.Profile update failed'),
                data: $e->getMessage()
            );
        }
    }

    public function changePassword($request, $user)
    {
        if (!Hash::check($request->current_password, $user->password)) {
            return responseFail(
                status: Http::BAD_REQUEST,
                message: __('messages.Current password is incorrect')
            );
        }

        try {
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            return responseSuccess(
                message: __('messages.Password changed successfully')
            );
        } catch (\Exception $e) {
            return responseFail(
                status: Http::INTERNAL_SERVER_ERROR,
                message: __('messages.Password change failed'),
                data: $e->getMessage()
            );
        }
    }

    public function getDashboard($user)
    {
        try {
            $user->load(['riskAssessment', 'activeSubscription.subscriptionPackage', 'bank']);

            return responseSuccess(
                message: __('messages.Dashboard data retrieved successfully'),
                data: [
                    'user' => new UserResource($user, false),
                    'risk_assessment' => $user->riskAssessment,
                    'active_subscription' => $user->activeSubscription,
                ]
            );
        } catch (\Exception $e) {
            return responseFail(
                status: Http::INTERNAL_SERVER_ERROR,
                message: __('messages.Failed to retrieve dashboard data'),
                data: $e->getMessage()
            );
        }
    }
}
