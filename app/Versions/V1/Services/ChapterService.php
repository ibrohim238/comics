<?php

namespace App\Versions\V1\Services;

use App\Models\Chapter;
use App\Models\Manga;
use App\Models\Team;
use App\Versions\V1\Dto\ChapterDto;

class ChapterService
{
    public function __construct(
        public Chapter $chapter,
    ) {
    }

    public function create(ChapterDto $dto, Team $team, Manga $manga): Chapter
    {
        $this
            ->fill($dto)
            ->associateTeam($team)
            ->associateManga($manga)
            ->save()
            ->addImages($dto->images);

        return $this->chapter;
    }

    public function update(ChapterDto $dto): Chapter
    {
        $this
            ->fill($dto)
            ->save()
            ->addImages($dto->images);

        return $this->chapter;
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

    public function addImages(?array $images): static
    {
        if ($images) {
            $this->chapter->addMultipleMediaFromRequest(['images'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection();
                });
        }

        return $this;
    }

    public function delete()
    {
        $this->chapter->clearMediaCollection();
        $this->chapter->delete();
    }
}
