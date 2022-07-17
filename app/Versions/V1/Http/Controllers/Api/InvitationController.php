<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Invitation;
use App\Models\User;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Resources\InvitationCollection;
use App\Versions\V1\Repositories\UserRepository;
use App\Versions\V1\Services\UserInviteService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use function app;
use function response;

class InvitationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @throws AuthorizationException
     */
    public function index(User $user, Request $request): InvitationCollection
    {
        $this->authorize('viewAny', [Invitation::class, $user]);

        $invitations = app(UserRepository::class, [
            'user' => $user
        ])->paginateInvitation($request->get('count'));

        return new InvitationCollection($invitations);
    }

    /**
     * @throws AuthorizationException
     */
    public function accept(User $user, Invitation $invitation): JsonResponse
    {
        $this->authorize('accept', $invitation);

        app(UserInviteService::class)->accept($invitation);

        return response()->json([
           'message' => 'приглашение принята!'
        ]);
    }


    /**
     * @throws AuthorizationException
     */
    public function reject(User $user, Invitation $invitation): JsonResponse
    {
        $this->authorize('accept', $invitation);

        app(UserInviteService::class)->reject($invitation);

        return response()->json([
            'message' => 'приглашение отклонена!'
        ]);
    }
}
