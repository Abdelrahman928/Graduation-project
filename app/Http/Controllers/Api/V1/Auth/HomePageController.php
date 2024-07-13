<?php

namespace App\Http\Controllers\api\v1\auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\PartnerResource;
use App\Http\Resources\RedeemHistoryResource;
use App\Models\Partners;
use App\Models\RedeemHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomePageController extends Controller
{
    public function __invoke(){
        $user = Auth::user();

        $partners = Partners::take()->get(5);
        return PartnerResource::collection($partners);

        $history = RedeemHistory::take()->get(5);
        return RedeemHistoryResource::collection($history);
    }
}
