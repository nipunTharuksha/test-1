<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{

    /**
     * @param UserLoginRequest $request
     * @return JsonResponse
     */
    public function login(UserLoginRequest $request): JsonResponse
    {

        $data = $request->validated();

        if (!(auth()->attempt($data))) {
            return response()->json(['error' => 'Incorrect username or password, please try again.'], 422);
        }

        $user = User::find(Auth::id());

        if (!($user->otp_verified)) {
            return response()->json(['error' => 'Please verify your OTP in order to login.'], 422);
        }

        $isAdmin = $user->user_role === 'admin';

        return response()->json([
            'user' => $user,
            'token' => $user->createToken($isAdmin ? 'Admin token' : 'User token', [$isAdmin ? 'admin' : 'user'])->accessToken,
        ], 200);
    }
}
