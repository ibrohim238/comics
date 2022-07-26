<?php

namespace App\Versions\V1\Services;

use App\Interfaces\Commentable;
use App\Models\Comment;
use App\Versions\V1\Dto\CommentDto;
use App\Versions\V1\Repositories\CommentRepository;

class CommentService
{
    private CommentRepository $repository;

    public function __construct(
      private Comment $comment
    ) {
        $this->repository = app(CommentRepository::class, [
           'comment' => $this->comment,
        ]);
    }

    public function update(CommentDto $dto): Comment
    {
        return $this->repository
            ->update($dto);
    }

    public function destroy(): void
    {
        $this->repository
            ->delete();
    }
}
