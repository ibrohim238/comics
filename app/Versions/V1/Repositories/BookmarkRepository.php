<?php

namespace App\Versions\V1\Repositories;

use App\Enums\BookmarkTypeEnum;
use App\Interfaces\Bookmarkable;
use App\Models\User;

class BookmarkRepository
{
    public function __construct(
        private Bookmarkable $bookmarkable,
        private User $user,
        private BookmarkTypeEnum $type,
    )
    {
    }

    public function attach(): static
    {
        $this->bookmarkable
            ->bookmarkUsers()
            ->attach(
                $this->user->id,
                ['type' => $this->type->value],
            );

        return $this;
    }

    public function detach(): static
    {
        $this->bookmarkable
            ->bookmarkUsers()
            ->wherePivot('type', $this->type->value)
            ->detach($this->user->id);

        return $this;
    }

    public function exists(): bool
    {
        return $this->bookmarkable
            ->bookmarkUsers()
            ->where('user_id', $this->user->id)
            ->where('type', $this->type->value)
            ->exists();
    }
}