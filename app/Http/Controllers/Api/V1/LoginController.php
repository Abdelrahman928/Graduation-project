<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function loginUser(LoginRequest $request){
        $attributes = $request->validated($request->all());

        if (! Auth::attempt($attributes)) {
            return response()->json(['error' => 'Sorry, those credentials do not match.'], 422);
        }

        $user = User::where('email', $request->email)->first();

        $device = substr($request->userAgent() ?? ' ', 0, 255);
        return response()->json([
            'access_token' => $user->createToken($device, ['access-user-account'])->plainTextToken
        ]);
    }

    public function logoutUser(){
        Auth::user()->currentAccessToken()->delete();
        
        return response()->json(['success' => 'logged out.', 200]);
    }
}
