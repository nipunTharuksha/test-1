<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminUserInvitationStoreRequest;
use App\Http\Resources\AdminResource;
use App\Models\Invitation;
use App\Notifications\AdminInviteToUserInvitationNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserManagementController extends Controller
{

    /**
     * @param AdminUserInvitationStoreRequest $request
     * @return AdminResource
     */
    public function store(AdminUserInvitationStoreRequest $request): AdminResource
    {
        $plainToken = hash_hmac('sha256', Str::random(40), config('app.key'));

        $newInvitation = Invitation::create(collect($request->validated())->put('token', Hash::make($plainToken))->toArray());
        $newInvitation->notify(new AdminInviteToUserInvitationNotification($plainToken));

        return new AdminResource(($newInvitation));
    }
}
