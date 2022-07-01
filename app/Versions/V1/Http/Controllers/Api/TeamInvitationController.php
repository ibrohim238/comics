<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Invitation;
use App\Models\Team;
use App\Versions\V1\Dto\InvitationDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\Api\InvitationRequest;
use App\Versions\V1\Http\Resources\InvitationCollection;
use App\Versions\V1\Http\Resources\InvitationResource;
use App\Versions\V1\Services\InvitationService;
use Illuminate\Http\Request;

class TeamInvitationController extends Controller
{
    public function index(Team $team, Request $request)
    {
        $this->authorize('teamInvitation', $team);

        $invitations = $team->invitations()->paginate($request->get('count'));

        return new InvitationCollection($invitations);
    }

    public function show(Team $team, Invitation $invitation)
    {
        $this->authorize('teamInvitation', $team);

        return new InvitationResource($invitation);
    }

    public function store(Team $team, InvitationRequest $request)
    {
        $this->authorize('teamInvitation', $team);

        $invitation = app(InvitationService::class)->store(
            $team, InvitationDto::fromRequest($request)
        );

        return new InvitationResource($invitation);
    }

    public function update(Team $team, Invitation $invitation, InvitationRequest $request)
    {
        $this->authorize('teamInvitation', $team);

        app(InvitationService::class, [
            'invitation' => $invitation
        ])->update(InvitationDto::fromRequest($request));

        return new InvitationResource($invitation);
    }

    public function destroy(Team $team, Invitation $invitation)
    {
        $this->authorize('teamInvitation', $team);

        app(InvitationService::class, [
            'invitation' => $invitation
        ])->delete();

        return response()->noContent();
    }
}
