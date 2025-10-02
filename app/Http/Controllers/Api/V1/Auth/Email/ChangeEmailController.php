<?php

namespace App\Http\Controllers\Api\V1\Auth\Email;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\Email\ChangeEmailRequest;
use App\Http\Requests\Api\V1\Auth\Email\ChangeEmailVerifyRequest;
use App\Http\Services\Api\V1\Auth\Email\EmailService;

class ChangeEmailController extends Controller
{
    public function __construct(
        private EmailService $service
    ) {}

    public function sendOtp(ChangeEmailRequest $request)
    {
        return $this->service->sendOtp($request);
    }

    public function change(ChangeEmailVerifyRequest $request)
    {
        return $this->service->change($request);
    }
}
