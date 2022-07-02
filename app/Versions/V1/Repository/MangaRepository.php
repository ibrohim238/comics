<?php

namespace App\Versions\V1\Repository;

use App\Models\Chapter;
use App\Models\Manga;
use App\Versions\V1\Dto\MangaDto;
use App\Versions\V1\Services\ChapterService;
use App\Versions\V1\Services\FilterSynchronizer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class MangaRepository
{
    public function __construct(
        private Manga $manga
    ) {
    }

    public function paginate(?int $perPage): LengthAwarePaginator
    {
        return QueryBuilder::for($this->manga)
            ->allowedFilters(
                AllowedFilter::exact('teams', 'teams.id'),
                AllowedFilter::exact('genres', 'genres.name'),
                AllowedFilter::exact('categories', 'categories.name'),
                AllowedFilter::exact('tags', 'tags.name')
            )
            ->paginate($perPage);
    }

    public function load(): Manga
    {
        return $this->manga->load('categories', 'genres', 'tags');
    }

    public function fill(MangaDto $dto): static
    {
        $this->manga->fill($dto->toArray());

        return $this;
    }

    public function save(): static
    {
        $this->manga->save();

        return $this;
    }

    public function addMedia(MangaDto $dto): static
    {
        if ($dto->image) {
            $this->manga->addMediaFromRequest('image')->toMediaCollection();
        }

        return $this;
    }

    public function syncFilter(MangaDto $dto): static
    {
        app(FilterSynchronizer::class, [
            'filters' => $dto->filters,
            'filterable' => $this->manga
        ])->sync();

        return $this;
    }

    public function deleteChapters(): static
    {
        $this->manga->chapters()->each(function (Chapter $chapter) {
            app(ChapterService::class, [
                'chapter' => $chapter
            ])->delete();
        });

        return $this;
    }

    public function deleteMedia(): static
    {
        $this->manga->clearMediaCollection();

        return $this;
    }

    public function delete(): static
    {
        $this->manga->delete();

        return $this;
    }
}
