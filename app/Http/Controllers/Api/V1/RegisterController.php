<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Ichtrojan\Otp\Otp;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request)
    {
        $user = User::create($request->validated());
        $otp = (new Otp)->generate($user->email,'numeric', 4, 15);

        $user->notify(new VerifyEmailNotification($otp));

        $device = substr($request->userAgent() ?? ' ', 0, 255);
        return response()->json([
            'message' => 'User registered successfully. Verify OTP to complete registration.',200
            ,'access_token' => $user->createToken($device, ['access-user-account'])->plainTextToken
        ]);
    }
}
