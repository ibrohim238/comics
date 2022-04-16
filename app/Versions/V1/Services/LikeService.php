<?php

namespace App\Versions\V1\Services;

use App\Models\Likeable;
use App\Models\User;

class LikeService
{
    public function __construct(
        public Likeable $likeable,
        public User $user
    ) {
    }

    public function add()
    {
        $this->likeable
            ->likes()
            ->save($this->user);
    }

    public function delete()
    {
        $this->likeable
            ->likes()
            ->where('user_id', $this->user->id)
            ->delete();
    }
}
