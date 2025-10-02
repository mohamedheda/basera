<?php

namespace App\Http\Controllers\Api\V1\Auth\Otp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Otp\OtpVerifyRequest;
use App\Http\Services\Api\V1\Auth\Otp\OtpService;

class OtpController extends Controller
{
    public function __construct(
        private readonly OtpService $otpService
    ) {}

    public function send()
    {
        return $this->otpService->generate();
    }

    public function verify(OtpVerifyRequest $request)
    {
        return $this->otpService->verify($request);
    }
}
