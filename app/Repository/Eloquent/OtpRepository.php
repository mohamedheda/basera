<?php

namespace App\Repository\Eloquent;

use App\Models\Otp;
use App\Repository\OtpRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Str;

class OtpRepository extends Repository implements OtpRepositoryInterface
{
    public function __construct(Otp $model)
    {
        parent::__construct($model);
    }

    public function generateOtp($user = null)
    {
        if (! $user) {
            $user = auth('api')->user();
        }
        $user->otps()?->delete();

        return $user->otp()?->create([
            //            'otp' => rand(1234, 9999), //TODO uncomment this and remove 1111
            'otp' => 1111,
            'expire_at' => Carbon::now()->addMinutes(5),
            'token' => Str::random(30),
        ]);
    }

    public function generateOtpForEmail($email, $user = null)
    {
        if (! $user) {
            $user = auth('api')->user();
        }
        $user->otps()?->delete();

        return $user->otp()?->create([
            //            'otp' => rand(1234, 9999), //TODO uncomment this and remove 1111
            'email' => $email,
            'otp' => 1111,
            'expire_at' => Carbon::now()->addMinutes(5),
            'token' => Str::random(30),
        ]);
    }

    public function check($otp, $token, $user = null)
    {
        if (! $user) {
            $user = auth('api')->user();
        }

        return $this->model::query()
            ->where('user_id', $user->id)
            ->where('otp', $otp)
            ->where('token', $token)
            ->where('expire_at', '>', Carbon::now())
            ->exists();
    }

    public function checkForEmail($otp, $token, $email)
    {
        return $this->model::query()
            ->where('user_id', auth('api')->id())
            ->where('otp', $otp)
            ->where('email', $email)
            ->where('token', $token)
            ->where('expire_at', '>', Carbon::now())
            ->exists();
    }
}
