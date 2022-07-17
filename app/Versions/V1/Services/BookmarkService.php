<?php

namespace App\Versions\V1\Services;

use App\Exceptions\BookmarksException;
use App\Interfaces\Bookmarkable;
use App\Models\User;

class BookmarkService
{
    public function __construct(
        public Bookmarkable $bookmarkable,
        public User $user,
    ) {
    }

    public function attach(): void
    {
        if($this->exists()) {
            throw BookmarksException::exists();
        }

        $this->bookmarkable->bookmarkUsers()->attach($this->user->id);
    }

    public function detach(): void
    {
        if(! $this->exists()) {
            throw BookmarksException::notFound();
        }

        $this->bookmarkable->bookmarkUsers()->detach([$this->user->id]);
    }

    private function exists(): bool
    {
        return $this->bookmarkable
            ->bookmarkUsers()
            ->where('id', $this->user->id)
            ->exists();
    }
}
