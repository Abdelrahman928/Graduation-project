<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\RedeemHistoryResource;
use App\Models\RedeemHistory;
use Illuminate\Support\Facades\Auth;

class RedeemHistoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $redeemHistory = RedeemHistory::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        return RedeemHistoryResource::collection($redeemHistory);
    }

    public function show(RedeemHistory $redeemHistory)
    {
        $user = Auth::user();

        if ($redeemHistory->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return new RedeemHistoryResource($redeemHistory);
    }
}
