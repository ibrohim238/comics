<?php

namespace App\Versions\V1\Repository;

use App\Models\Manga;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class MangaRepository
{
    public function __construct(
      public Manga|MorphToMany $manga
    ) {
    }

    public function paginate(?int $per_page): LengthAwarePaginator
    {
        return QueryBuilder::for($this->manga)
            ->with('media')
            ->allowedFilters(
                AllowedFilter::exact('genres', 'genres.name'),
                AllowedFilter::exact('categories', 'categories.name'),
                AllowedFilter::exact('tags', 'tags.name')
            )
            ->paginate($per_page);
    }
}
