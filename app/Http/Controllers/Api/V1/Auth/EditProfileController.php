<?php

namespace App\Http\Controllers\api\v1\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EditProfileController extends Controller
{
    public function changeName(RegisterRequest $request){
        $user = Auth::user();

        $newName = $request->validated($request->only(['first_name', 'last_name']));

        $user->update(['first_name' => $newName->first_name, 'last_name' => $newName->last_name]);

        return response()->json(['message' => 'User name updated successfully', 200]);
    }

    public function changeEmail(RegisterRequest $request){
        $user = Auth::user();

        $newEmail = $request->validated($request->only('Email'));
        $user->update(['Email' => $newEmail]);

        return response()->json(['message' => 'Email updated successfuly', 200]);
    }
}
