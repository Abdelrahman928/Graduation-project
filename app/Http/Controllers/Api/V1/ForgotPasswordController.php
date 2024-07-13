<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetEmailRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForgotPasswordController extends Controller
{
    public function getUserEmail(GetEmailRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if(! $user)
        {
            return response()->json(['error' => 'we could not find an account for the email you provided', 404]);
        }

        $otp = (new Otp)->generate($user->email,'numeric', 6, 15);
        $user->notify(new ResetPasswordNotification($otp));
        
        return response()->json([
            'access_token' => $user->createToken('reset-password', ['reset-password'], now()->addHour(1))->plainTextToken,
            'success' => 'pasword reset email sent', 200
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $user = Auth::user();
        $otpv = (new Otp)->validate($user->email, $request->otp);

        if (! $otpv)
        {
            return response()->json(['error' =>$otpv ,401]);
        }

        return response()->json(['success' => $otpv, 200]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = Auth::user();

        $newpass = $request->validated($request->except('current_password'));

        $user->update(['password'=> $newpass]);
        $user->tokens()->delete();

        return response()->json(['success' => 'Password updated successfully', 200]);
    }
}
