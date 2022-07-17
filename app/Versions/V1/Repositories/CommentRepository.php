<?php

namespace App\Versions\V1\Repositories;

use App\Models\Comment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;

class CommentRepository
{
    public function __construct(
        private Comment $comment
    ) {
    }

    public function paginate(?int $perPage): LengthAwarePaginator
    {
        return QueryBuilder::for($this->comment)
            ->allowedFilters([

            ])
            ->paginate($perPage);
    }

}