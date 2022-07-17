<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Invitation;
use App\Models\Team;
use App\Versions\V1\Dto\InvitationDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\TeamInvitationRequest;
use App\Versions\V1\Http\Resources\InvitationCollection;
use App\Versions\V1\Http\Resources\InvitationResource;
use App\Versions\V1\Repositories\TeamRepository;
use App\Versions\V1\Services\InvitationService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use function app;
use function response;

class TeamInvitationController extends Controller
{
    public function index(Team $team, Request $request): InvitationCollection
    {
        $invitations = app(TeamRepository::class, [
            'team' => $team
        ])->invitationPaginate($request->get('count'));

        return new InvitationCollection($invitations);
    }

    public function show(Team $team, Invitation $invitation): InvitationResource
    {
        return new InvitationResource($invitation);
    }

    public function store(Team $team, TeamInvitationRequest $request): InvitationResource
    {
        $invitation = app(InvitationService::class)->store(
            $team, InvitationDto::fromRequest($request)
        );

        return new InvitationResource($invitation);
    }

    public function update(Team $team, Invitation $invitation, TeamInvitationRequest $request): InvitationResource
    {
        app(InvitationService::class, [
            'invitation' => $invitation
        ])->update(InvitationDto::fromRequest($request));

        return new InvitationResource($invitation);
    }

    public function destroy(Team $team, Invitation $invitation): Response
    {
        app(InvitationService::class, [
            'invitation' => $invitation
        ])->delete();

        return response()->noContent();
    }
}
