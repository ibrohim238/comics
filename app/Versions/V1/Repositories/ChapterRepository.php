<?php

namespace App\Versions\V1\Repositories;

use App\Models\Chapter;
use App\Models\Manga;
use App\Models\Team;
use App\Versions\V1\Dto\ChapterDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ChapterRepository
{
    public function __construct(
        private Chapter $chapter
    ) {
    }

    public function paginate(?int $perPage): LengthAwarePaginator
    {
        return QueryBuilder::for($this->chapter)
            ->with('team', 'manga')
            ->allowedFilters([
               AllowedFilter::exact('manga', 'manga.slug')
            ])->paginate($perPage);
    }

    public function getChapter(): Chapter
    {
        return $this->chapter;
    }

    public function load(): static
    {
        $this->chapter->load('manga.media', 'media');

        return $this;
    }

    public function fill(array $data): static
    {
        $this->chapter->fill($data);

        return $this;
    }

    public function save(): static
    {
        $this->chapter->save();

        return $this;
    }

    public function associateTeam(?int $teamId): static
    {
        $this->chapter->team()->associate($teamId);

        return $this;
    }

    public function addMedia(?array $images): static
    {
        if (! is_null($images)) {
            $this->chapter->addMultipleMediaFromRequest(['media'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection();
                });
        }

        return $this;
    }

    public function associateManga(Manga $manga): static
    {
        $this->chapter->manga()->associate($manga);

        return $this;
    }

    public function deleteMedia(): static
    {
        $this->chapter->clearMediaCollection();

        return $this;
    }

    public function delete(): static
    {
        $this->chapter->delete();

        return $this;
    }
}
