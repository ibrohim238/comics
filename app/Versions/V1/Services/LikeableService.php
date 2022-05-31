<?php

namespace App\Versions\V1\Services;

use App\Exceptions\LikealeException;
use App\Models\Likeable;
use App\Models\User;

class LikeableService
{
    public function __construct(
        public Likeable $likeable,
        public User $user,
    ) {

    }

    public function add()
    {
        if($this->exists()) {
            throw LikealeException::exists();
        }

        $this
            ->likeable
            ->likes()
            ->attach([$this->user->id]);
    }

    public function delete()
    {
        if(! $this->exists()) {
            throw LikealeException::notFound();
        }

        $this->likeable
            ->likes()
            ->detach([$this->user->id]);
    }

    private function exists(): bool
    {
        return $this->likeable
            ->likes()
            ->where('user_id', $this->user->id)
            ->exists();
    }
}
