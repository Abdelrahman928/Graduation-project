<?php

namespace App\Http\Controllers\api\v1\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChangePasswordController extends Controller
{
    // public function sendPasswordResetRequest(User $user)
    // {
    //     $user = Auth::user();

    //     $otp = (new Otp)->generate($user->email,'numeric', 6, 15);
    //     $user->notify(new ResetPasswordNotification($otp));

    //     return response()->json(['success' => 'password reset email sent.', 200]);
    // }

    // public function verifyOtp(Request $request)
    // {
    //     $user = Auth::user();
    //     $otpv = (new Otp)->validate($user->email, $request->otp);

    //     if (! $otpv)
    //     {
    //         return response()->json($otpv, 400);
    //     }
    //     return response()->json($otpv);
    // }

    public function __invoke(ResetPasswordRequest $request)
    {
        $user = Auth::user();
        $newPassword = $request->validated($request->all());

        if($request->current_password !== $user->password)
        {
            return response()->json(['error' => 'your need to enter your current password correctly to reset your password', 403]);
        }

        if (! $newPassword)
        {
            return response()->json($newPassword, 400);
        }

        $user->update(['password' => $newPassword]);
    }
}
