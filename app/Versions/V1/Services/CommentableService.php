<?php

namespace App\Versions\V1\Services;

use App\Interfaces\Commentable;
use App\Models\Comment;
use App\Versions\V1\Dto\CommentDto;
use App\Versions\V1\Repositories\CommentableRepository;

class CommentableService
{
    private CommentableRepository $repository;

    public function __construct(
      private Commentable $commentable
    ) {
        $this->repository = app(CommentableRepository::class, [
           'commentable' => $this->commentable
        ]);
    }

    public function store(CommentDto $dto): Comment
    {
        return $this->repository
            ->store($dto->toArray());
    }
}