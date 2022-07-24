<?php

namespace App\Versions\V1\Services;

use App\Exceptions\BookmarksException;
use App\Interfaces\Bookmarkable;
use App\Models\User;
use App\Versions\V1\Dto\BookmarkDto;
use App\Versions\V1\Repositories\BookmarkRepository;

class BookmarkService
{
    private BookmarkRepository $repository;

    public function __construct(
        private Bookmarkable $bookmarkable,
        private User $user,
        private BookmarkDto $dto,
    ) {
        $this->repository = app(BookmarkRepository::class, [
            'bookmarkable' => $this->bookmarkable,
            'user' => $this->user,
            'type' => $this->dto->type,
        ]);
    }

    public function attach(): void
    {
        if ($this->repository->exists()) {
            throw BookmarksException::exists();
        }

        $this->repository->attach();
    }

    public function detach(): void
    {
        if (!$this->repository->exists()) {
            throw BookmarksException::notFound();
        }

        $this->repository->detach();
    }
}
