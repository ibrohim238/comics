<?php

namespace App\Versions\V1\Repositories;

use App\Interfaces\Commentable;
use App\Models\Comment;
use App\Versions\V1\Dto\CommentDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;

class CommentRepository
{
    public function __construct(
        private Comment $comment,
    ) {
    }

    public function loadChild(int $parentId, ?int $perPage): LengthAwarePaginator
    {
        return QueryBuilder::for($this->comment)
            ->with('user')
            ->where('parent_id', $parentId)
            ->paginate($perPage);
    }

    public function update(CommentDto $dto): Comment
    {
        $this->comment->update(
            $dto
                ->only('content')
                ->toArray()
        );

        return $this->comment;
    }

    public function delete()
    {
        $this->comment->delete();
    }
}