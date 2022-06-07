<?php

namespace App\Repository;

use App\Models\Manga;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class MangaRepository
{
    public function paginate(int $per_page): LengthAwarePaginator
    {
        return QueryBuilder::for(Manga::class)
            ->with('media', 'ratings', 'chapterVotes')
            ->allowedFilters(
                AllowedFilter::exact('genres', 'genres.name'),
                AllowedFilter::exact('categories', 'categories.name'),
                AllowedFilter::exact('tags', 'tags.name')
            )
            ->paginate($per_page);
    }
}
