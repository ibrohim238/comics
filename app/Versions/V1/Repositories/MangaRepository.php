<?php

namespace App\Versions\V1\Repositories;

use App\Dto\MangaDto;
use App\Models\Chapter;
use App\Models\Manga;
use App\Models\Team;
use App\Versions\V1\Services\ChapterService;
use App\Versions\V1\Services\TagSynchronizer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class MangaRepository
{
    public function __construct(
        private Manga $manga
    ) {
    }

    public function paginateChapter(Team $team, ?int $perPage): LengthAwarePaginator
    {
        return QueryBuilder::for($this->manga->chapters())
            ->with('team')
            ->where('team_id', $team->id)
            ->defaultSorts('-volume', '-number')
            ->allowedSorts('volume', 'number')
            ->paginate($perPage);
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
        if ($dto->image) {
            $this->manga->addMediaFromRequest('image')->toMediaCollection();
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
