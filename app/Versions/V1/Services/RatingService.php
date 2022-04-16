<?php

namespace App\Versions\V1\Services;

use App\Models\Rateable;
use App\Models\User;
use App\Versions\V1\Dto\RatingDto;

class RatingService
{
    public function __construct(
        public Rateable $rateable,
        public User $user,
    ) {
    }

    public function add(RatingDto $dto)
    {
        /* @var Rateable $rateable */
        $this->rateable->ratings()
            ->updateOrCreate([
                'user_id' => $this->user->id,
            ], $dto->toArray());
    }

    public function delete(): void
    {
        $this->rateable->ratings()
            ->where('user_id', $this->user->id)
            ->delete();
    }
}