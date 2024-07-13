<?php

namespace App\Http\Controllers\api\v1\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyRequest;
use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Auth;
use Illuminate\Http\Request;
use Ichtrojan\Otp\Otp;

class EmailVerificationController extends Controller
{
    protected $user;

    public function __invoke(VerifyRequest $request)
    {
        $user = Auth::user();
        $otpv = (new Otp)->validate($user->email, $request->otp);

        $isValid = $otpv->status;
        $message = $otpv->message;
        
            if(! $isValid)
            {
                return response()->json([$message, 400]);
            }
        $user->markEmailAsVerified();
        return response()->json(['email verified successfully', 200]);
    }
}
