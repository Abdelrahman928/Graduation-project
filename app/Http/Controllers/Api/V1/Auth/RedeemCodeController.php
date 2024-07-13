<?php

namespace App\Http\Controllers\api\v1\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RedeemCodeRequest;
use App\Models\PromoCode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RedeemCodeController extends Controller
{
    public function __invoke(RedeemCodeRequest $request)
    {
        $user = Auth::user();
        $promoCode = $request->validated($request->promo_code);
        $code = PromoCode::where('promo_code', $promoCode)->first();
        $validity = $code->created_at->addMinutes($code->validity);

        if (! $code || !$promoCode) {
            return response()->json(['error' => 'The code you entered is invalid.'], 400);
        }
    
        $validity = $code->created_at->addHours($code->validity);
    
        if ($validity->isPast()) {
            $code->update(['valid' => false]);
            return response()->json(['error' => 'This code has expired.'], 400);
        }

        $pointsToAdd = 100;
        $user->user_points += $pointsToAdd;
        $code->update(['valid' => false]);

        return response()->json(['message' => 'Congratulations! 100 points have been added to your account.', 200]);
    }
}
