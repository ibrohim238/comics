<?php

namespace App\Versions\V1\Repository;

use App\Interfaces\Invited;
use App\Models\Invitation;
use App\Models\User;
use App\Versions\V1\Dto\InvitationDto;

class InvitedRepository
{
    public function __construct(
        private Invited $invited
    ) {
    }

    public function create(InvitationDto $dto): static
    {
        $this->invited->invitations()->create($dto->toArray());

        return $this;
    }

    public function save(): static
    {
        $this->invited->save();

        return $this;
    }

    public function associateUser(User $user): static
    {
        $this->invited->user()->associate($user);

        return $this;
    }

    public function delete(): static
    {
        $this->invited->delete();

        return $this;
    }
}
