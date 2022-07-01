<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Invitation;
use App\Models\User;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Resources\InvitationCollection;
use App\Versions\V1\Services\UserInviteService;
use Illuminate\Auth\Access\AuthorizationException;

class InvitationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Invitation::class);
    }

    public function index(User $user)
    {
        $invitations = $user->invitations()->get();

        return new InvitationCollection($invitations);
    }

    public function accept(User $user, Invitation $invitation)
    {
        app(UserInviteService::class)->accept($invitation);
    }


    public function reject(User $user, Invitation $invitation)
    {
        app(UserInviteService::class)->reject($invitation);
    }
}
