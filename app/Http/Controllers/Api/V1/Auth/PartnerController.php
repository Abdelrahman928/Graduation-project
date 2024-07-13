<?php

namespace App\Http\Controllers\api\v1\auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\PartnerResource;
use App\Models\Partners;
use App\Models\RedeemHistory;
use Illuminate\Support\Facades\Auth;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partners::all();
        return PartnerResource::collection($partners);
    }

    public function show(Partners $partner)
    {
        if (!$partner) 
        {
            return response()->json(['error' => 'record not found'], 404);
        }
    
        return new PartnerResource($partner);
    }

    public function redeem(Partners $partner)
    {
        $user = Auth::user();
        if (!$partner) 
        {
            return response()->json(['error' => 'record not found'], 404);
        }

        if($user->user_points < $partner->points_required)
        {
            return response()->json(['error' => 'insufficient balance', 400]);
        }

        RedeemHistory::create([
            'user_id' => Auth::id(),
            'partner_name' => $partner->name,
            'partner_description' => $partner->description,
            'points_paid' => $partner->points_required
        ]);
        return response()->json(['message' => 'Congratulations!, your promo code from '. $partner->name. ' has been added to your account', 200]);
    }
}