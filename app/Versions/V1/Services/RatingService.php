<?php

namespace App\Versions\V1\Services;

use App\Exceptions\RatingableException;
use App\Models\Rateable;
use App\Models\Rating;
use App\Models\User;
use App\Versions\V1\Dto\RatingDto;

class RatingService
{
    public function __construct(
        public Rateable $rateable,
        public User $user,
    ) {
    }

    public function updateOrCreate(RatingDto $dto)
    {
        $this->rateable->ratings()
            ->updateOrCreate([
                'user_id' => $this->user->id,
            ], $dto->toArray());
    }

    public function delete(): void
    {
        if (! $this->rateable->ratings()->where('user_id', $this->user->id)->exists()) {
            throw RatingableException::notFound();
        }

        $this->rateable->ratings()
            ->where('user_id', $this->user->id)
            ->delete();
    }
}
