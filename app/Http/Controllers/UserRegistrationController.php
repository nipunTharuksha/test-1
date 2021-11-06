<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserOtpVerificationRequest;
use App\Http\Requests\UserRegistrationRequest;
use App\Http\Requests\UserRegistrationValidateTokenRequest;
use App\Models\Invitation;
use App\Models\User;
use App\Notifications\UserOtpNotification;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserRegistrationController extends Controller
{
    /**
     * @param UserRegistrationValidateTokenRequest $request
     * @return JsonResponse
     */
    public function validateToken(UserRegistrationValidateTokenRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (($this->tokenValidation($data['email'], $data['token']))) {
            return response()->json(['message' => ' Invalid token or email.'], 422);
        }

        return response()->json(['success' => true]);
    }

    /**
     * @param $email
     * @param $token
     * @return bool
     */
    protected function tokenValidation($email, $token): bool
    {
        $invitation = Invitation::whereEmail($email)->first();
        return !($invitation && Hash::check($token, $invitation->token));
    }

    /**
     * @param UserRegistrationRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function store(UserRegistrationRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (($this->tokenValidation($data['email'], $data['token']))) {
            return response()->json(['message' => ' Invalid token or email.'], 422);
        }
        $hashedPassword = Hash::make($data['password']);

        $user = User::create(collect($data)->forget(['token', 'password'])->put('password', $hashedPassword)->toArray());
        $otp = $user->otp()->create(['otp' => random_int(100000, 999999)])->otp;

        $user->notify(new UserOtpNotification($otp));

        Invitation::whereEmail($data['email'])->first()->delete();

        return response()->json(['success' => true]);
    }

    /**
     * @param UserOtpVerificationRequest $request
     * @return JsonResponse
     */
    public function activateAccount(UserOtpVerificationRequest $request): JsonResponse
    {
        $data = $request->validated();
        if ($this->verifyOtp($data['otp'], $data['email'])) {
            return response()->json(['message' => ' Invalid otp or email.'], 422);
        }

        $user = User::whereOtpVerified(false)->whereEmail($data['email'])->first();
        (clone $user)->update(['otp_verified' => true]);
        (clone $user)->otp->delete();

        return response()->json(['message' => 'You have completed registration process.Please login.', 'success' => true]);

    }

    /**
     * @param $otp
     * @param $email
     * @return bool
     */
    protected function verifyOtp($otp, $email): bool
    {
        $user = User::whereOtpVerified(false)->whereEmail($email)->first();
        return !($user && $user->otp && $user->otp !== $otp);

    }
}
