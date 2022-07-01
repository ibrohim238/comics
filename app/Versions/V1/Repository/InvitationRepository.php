<?php

namespace App\Versions\V1\Repository;

use App\Interfaces\Invited;
use App\Models\Invitation;
use App\Models\User;
use App\Versions\V1\Dto\InvitationDto;
use Illuminate\Database\Eloquent\Relations\Relation;

class InvitationRepository
{
    public function __construct(
        private Invitation $invitation
    ) {
    }

    public function fill(InvitationDto $dto): static
    {
        $this->invitation->fill($dto->toArray());

        return $this;
    }

    public function save(): static
    {
        $this->invitation->save();

        return $this;
    }

    public function associateUser(int $userId): static
    {
        $this->invitation->user()->associate($userId);

        return $this;
    }

    /**
     * @param Invited $invited
     * @return $this
     */
    public function associateInvited(Invited $invited): static
    {
        $this->invitation->invited()->associate($invited);

        return $this;
    }

    public function delete(): static
    {
        $this->invitation->delete();

        return $this;
    }
}
