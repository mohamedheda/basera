<?php

namespace App\Http\Services\Api\V1\Auth\Email;

use App\Http\Resources\V1\Otp\OtpResource;
use App\Repository\OtpRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\Facades\Mail;

use function App\Http\Helpers\responseFail;
use function App\Http\Helpers\responseSuccess;

class EmailService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private OtpRepositoryInterface $otpRepository
    ) {}

    public function sendOtp($request)
    {
        $data = $request->validated();
        $otp = $this->otpRepository->generateOtpForEmail(email: $data['email']);
        auth('api')->user()?->update([
            'otp_verified' => false,
        ]);

        // TODO: Send OTP to the new email (via mail service)
        return responseSuccess(message: __('messages.OTP_Is_Send'), data: new OtpResource($otp));
    }

    public function change($request)
    {
        $data = $request->validated();
        $check = $this->otpRepository->checkForEmail($request->otp, $request->otp_token, $data['email']);
        if ($check) {
            $this->userRepository->update(auth('api')->id(), [
                'email' => $request->email,
            ]);
            auth('api')->user()?->update([
                'otp_verified' => true,
            ]);
            auth('api')->user()->otps()?->delete();

            return responseSuccess(message: __('messages.Your email has been verified successfully'));
        } else {
            return responseFail(message: __('messages.Wrong OTP code'));
        }
    }
}
