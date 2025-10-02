<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\RiskAssessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Register a new user with complete profile information
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|unique:users',
            'password' => 'required|string|min:8',
            'id_number' => 'required|string|unique:users',
            'date_of_birth' => 'required|date|before:today',
            'marital_status' => 'required|in:single,married,divorced,widowed',
            'family_members_count' => 'required|integer|min:1',
            'education_level' => 'required|in:high_school,diploma,bachelor,master,phd',
            'annual_income' => 'required|numeric|min:0',
            'total_savings' => 'required|numeric|min:0',
            'bank_name' => 'required|string|max:255',
            // Risk assessment questions
            'has_investment_experience' => 'required|boolean',
            'willing_to_risk_capital' => 'required|boolean',
            'has_stable_income' => 'required|boolean',
            'plans_short_term_withdrawal' => 'required|boolean',
            'prefers_high_risk_high_return' => 'required|boolean',
            'consults_financial_advisor' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'id_number' => $request->id_number,
                'date_of_birth' => $request->date_of_birth,
                'marital_status' => $request->marital_status,
                'family_members_count' => $request->family_members_count,
                'education_level' => $request->education_level,
                'annual_income' => $request->annual_income,
                'total_savings' => $request->total_savings,
                'bank_name' => $request->bank_name,
                'profile_completed' => true,
            ]);

            // Create risk assessment
            $riskAssessment = RiskAssessment::create([
                'user_id' => $user->id,
                'has_investment_experience' => $request->has_investment_experience,
                'willing_to_risk_capital' => $request->willing_to_risk_capital,
                'has_stable_income' => $request->has_stable_income,
                'plans_short_term_withdrawal' => $request->plans_short_term_withdrawal,
                'prefers_high_risk_high_return' => $request->prefers_high_risk_high_return,
                'consults_financial_advisor' => $request->consults_financial_advisor,
            ]);

            // Calculate risk score
            $riskAssessment->calculateRiskScore()->save();

            // Generate JWT token
            $token = $user->token();

            return response()->json([
                'success' => true,
                'message' => 'User registered successfully',
                'data' => [
                    'user' => $user,
                    'risk_assessment' => $riskAssessment,
                    'token' => $token,
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user profile
     */
    public function profile(Request $request)
    {
        $user = $request->user();
        $user->load(['riskAssessment']);

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user,
                'risk_assessment' => $user->riskAssessment,
            ]
        ]);
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'sometimes|required|string|unique:users,phone,' . $user->id,
            'id_number' => 'sometimes|required|string|unique:users,id_number,' . $user->id,
            'date_of_birth' => 'sometimes|required|date|before:today',
            'marital_status' => 'sometimes|required|in:single,married,divorced,widowed',
            'family_members_count' => 'sometimes|required|integer|min:1',
            'education_level' => 'sometimes|required|in:high_school,diploma,bachelor,master,phd',
            'annual_income' => 'sometimes|required|numeric|min:0',
            'total_savings' => 'sometimes|required|numeric|min:0',
            'bank_name' => 'sometimes|required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user->update($request->only([
                'name',
                'email',
                'phone',
                'id_number',
                'date_of_birth',
                'marital_status',
                'family_members_count',
                'education_level',
                'annual_income',
                'total_savings',
                'bank_name'
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Profile update failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Change user password
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect'
            ], 400);
        }

        try {
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Password changed successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Password change failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user dashboard data
     */
    public function dashboard(Request $request)
    {
        $user = $request->user();
        $user->load(['riskAssessment', 'activeSubscription.subscriptionPackage']);

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user,
                'risk_assessment' => $user->riskAssessment,
                'active_subscription' => $user->activeSubscription,
            ]
        ]);
    }
}
