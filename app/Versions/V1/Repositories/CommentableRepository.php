<?php

namespace App\Versions\V1\Repositories;

use App\Interfaces\Commentable;
use App\Models\Comment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;

class CommentableRepository
{
    public function __construct(
        private Commentable $commentable,
    ) {
    }

    public function paginate(?int $perPage): LengthAwarePaginator
    {
        return QueryBuilder::for($this->commentable->comments())
            ->with('user')
            ->paginate($perPage);
    }

    public function store(array $data): Comment
    {
        return $this->commentable->comments()
            ->create($data);
    }
}