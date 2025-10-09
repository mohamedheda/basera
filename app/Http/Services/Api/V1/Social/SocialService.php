<?php

namespace App\Http\Services\Api\V1\Social;

use App\Http\Requests\Api\V1\Social\SocialRequest;
use App\Http\Resources\V1\User\UserResource;
use App\Repository\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

use function App\Http\Helpers\responseSuccess;

class SocialService
{

    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {}

    public function redirect($provider): JsonResponse
    {
        $link = Socialite::with($provider)->stateless()->redirect()->getTargetUrl();

        return responseSuccess(200, __('messages.created successfully'), $link);
    }

    public function callback($provider)
    {
        $userSocial = Socialite::with($provider)->stateless()->user();
        $user = $this->userRepository->first('email', $userSocial->getEmail());
        if (! $user) {
            $user = $this->userRepository->create([
                'name' => $userSocial->getName(),
                'email' => $userSocial->getEmail(),
                'provider_id' => $userSocial->getId(),
                'password' => Hash::make('Search@123'),
                'provider' => $provider,
                'is_active' => true,
                'otp_verified' => true,
            ]);
        }
        $user['token'] = $user->token();

        return responseSuccess(200, __('messages.Successfully authenticated'), new UserResource($user, true));
    }

    public function callbackMobile(SocialRequest $request): JsonResponse
    {
        $user = $this->userRepository->first('email', $request->email);

        if (! $user) {

            $user = $this->userRepository->create([
                'name' => $request->name,
                'email' => $request->email,
                'provider_id' => $request->provider_id,
                'provider' => $request->provider,
                'password' => Hash::make('Search@123'),
                'is_active' => true,
                'otp_verified' => true,
            ]);
        }

        $user['token'] = $user->token();

        return responseSuccess(200, __('messages.Successfully authenticated'), new UserResource($user, true));
    }
}
