<?php

namespace App\Versions\V1\Repositories;

use App\Models\Chapter;
use App\Models\Manga;
use App\Versions\V1\Dto\MangaDto;
use App\Versions\V1\Services\ChapterService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use function app;

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
                AllowedFilter::exact('tags', 'tags.name')
            )
            ->paginate($perPage);
    }

    public function getManga(): Manga
    {
        return $this->manga;
    }

    public function load(): static
    {
        $this->manga->load('tags');

        return $this;
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
        if ($dto->media) {
            $this->manga->addMediaFromRequest('media')->toMediaCollection();
        }

        return $this;
    }

    public function syncTags(MangaDto $dto): static
    {
        $this->manga->syncTags($dto->tags);

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
