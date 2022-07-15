<?php

namespace App\Versions\V1\Repositories;

use App\Dto\ChapterDto;
use App\Models\Chapter;
use App\Models\Manga;
use App\Models\Team;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ChapterRepository
{
    public function __construct(
        private Chapter $chapter
    ) {
    }

    public function getChapter(): Chapter
    {
        return $this->chapter;
    }

    public function load(): static
    {
        $this->chapter->load('manga.media');

        return $this;
    }

    public function fill(ChapterDto $dto): static
    {
        $this->chapter->fill($dto->toArray());

        return $this;
    }

    public function save(): static
    {
        $this->chapter->save();

        return $this;
    }

    public function associateTeam(Team $team): static
    {
        $this->chapter->team()->associate($team);

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
