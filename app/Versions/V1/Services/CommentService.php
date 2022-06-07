<?php

namespace App\Versions\V1\Services;

use App\Interfaces\Commentable;
use App\Models\Comment;
use App\Models\User;
use App\Versions\V1\Dto\CommentDto;

class CommentService
{
    public function create(Commentable $commentable, User $user, CommentDto $commentDto)
    {
        $commentable->comments()
            ->create([
                'user_id' => $user->id,
                'parent_id' => $commentDto->parentId,
                'body' => $commentDto->body,
            ]);
    }

    public function update(Comment $comment, CommentDto $commentData)
    {
        $comment->update([
            'body' => $commentData->body,
        ]);
    }

    public function delete(Comment $comment)
    {
        $comment->delete();
    }
}
