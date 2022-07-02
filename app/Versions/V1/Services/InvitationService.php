<?php

namespace App\Versions\V1\Services;

use App\Interfaces\Invited;
use App\Models\Invitation;
use App\Models\User;
use App\Versions\V1\Dto\InvitationDto;
use App\Versions\V1\Repository\InvitationRepository;

class InvitationService
{
    private InvitationRepository $repository;

    public function __construct(
        private Invitation $invitation,
    ) {
        $this->repository = app(InvitationRepository::class, [
           'invitation' => $this->invitation
        ]);
    }

    public function store(Invited $invited, InvitationDto $dto): Invitation
    {
        $this->repository
            ->fill($dto)
            ->associateUser($dto->user_id)
            ->associateInvited($invited)
            ->save();

        return $this->invitation;
    }

    public function update(InvitationDto $dto): Invitation
    {
        $this->repository
            ->fill($dto)
            ->save();

        return $this->invitation;
    }

    public function delete(): void
    {
        $this->repository
            ->delete();
    }
}
