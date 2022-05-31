<?php

namespace App\Versions\V1\Services;

use App\Exceptions\BookmarksException;
use App\Models\Manga;
use App\Models\User;

class BookmarkService
{
    public function __construct(
        public Manga $manga,
        public User $user,
    ) {
    }

    public function add(): void
    {
        if($this->user->bookmarks()->where('id', $this->manga->id)->exists()) {
            throw BookmarksException::exists();
        }

        $this->user->bookmarks()->attach([$this->manga->id]);
    }

    public function delete(): void
    {
        if(!$this->user->bookmarks()->where('id', $this->manga->id)->exists()) {
            throw BookmarksException::notFound();
        }

        $this->user->bookmarks()->detach([$this->manga->id]);
    }
}
