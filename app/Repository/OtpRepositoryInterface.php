<?php

namespace App\Repository;

interface OtpRepositoryInterface extends RepositoryInterface
{
    public function generateOtp($user = null);

    public function check($otp, $token, $user = null);

    public function generateOtpForEmail($email, $user = null);

    public function checkForEmail($otp, $token, $email);
}
