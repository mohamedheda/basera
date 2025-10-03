<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\RegisterRequest;
use App\Http\Requests\Api\V1\User\UpdateProfileRequest;
use App\Http\Requests\Api\V1\User\ChangePasswordRequest;
use App\Http\Services\Api\V1\User\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private readonly UserService $userService) {}

    public function register(RegisterRequest $request)
    {
        return $this->userService->register($request);
    }

    public function profile(Request $request)
    {
        return $this->userService->getProfile($request->user());
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        return $this->userService->updateProfile($request, $request->user());
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        return $this->userService->changePassword($request, $request->user());
    }

    public function dashboard(Request $request)
    {
        return $this->userService->getDashboard($request->user());
    }
}
