<?php

namespace App\Http\Services\Api\V1\Auth;

use App\Http\Helpers\Http;
use App\Http\Requests\Api\V1\Auth\SignInRequest;
use App\Http\Requests\Api\V1\Auth\SignUpRequest;
use App\Http\Resources\V1\User\UserResource;
use App\Http\Services\Api\V1\Auth\Otp\OtpService;
use App\Http\Services\PlatformService;
use App\Repository\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

use function App\Http\Helpers\responseFail;
use function App\Http\Helpers\responseSuccess;

abstract class AuthService extends PlatformService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly OtpService $otpService,
    ) {}

    public function signUp(SignUpRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            $user = $this->userRepository->create($data);

            $this->otpService->generate($user);
            $user->load('otp');
            DB::commit();

            return responseSuccess(Http::CREATED, __('messages.created successfully'), new UserResource($user, true));
        } catch (Exception $e) {
            DB::rollBack();

            //            dd($e);
            return responseFail(Http::BAD_REQUEST, __('messages.Something went wrong'));
        }
    }

    public function signIn(SignInRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $token = auth('api')->attempt($credentials);
        if ($token) {
            return responseSuccess(Http::CREATED, __('messages.Successfully authenticated'), new UserResource(auth('api')->user(), true));
        }

        return responseFail(Http::UNAUTHORIZED, __('messages.wrong credentials'));
    }

    public function signOut()
    {
        auth('api')->logout();

        return responseSuccess(Http::OK, __('messages.Successfully loggedOut'));
    }
}
