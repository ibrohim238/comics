<?php

namespace App\Versions\V1\Services;

use App\Models\Comment;
use App\Models\Commentable;
use App\Models\User;
use App\Versions\V1\Dto\CommentDto;

class CommentService
{
    public function create(Commentable $commentable, User $user, CommentDto $commentData)
    {
        $commentable->comments()
            ->create([
                'user_id' => $user->id,
                'parent_id' => $commentData->parentId,
                'body' => $commentData->body,
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
