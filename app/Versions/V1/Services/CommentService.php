<?php

namespace App\Versions\V1\Services;

use App\Interfaces\Commentable;
use App\Models\Comment;
use App\Versions\V1\Dto\CommentDto;

class CommentService
{
    public function create(Commentable $commentable, CommentDto $dto): Comment
    {
        return $commentable->comments()
            ->create($dto->toArray());
    }

    public function update(Comment $comment, CommentDto $dto)
    {
        $comment->update(
            $dto
                ->only('content')
                ->toArray()
        );
    }

    public function delete(Comment $comment)
    {
        $comment->delete();
    }
}
