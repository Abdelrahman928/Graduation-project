<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function __invoke(User $user)
    {
        $user = Auth::user();

        return new UserResource($user);
    }
}
