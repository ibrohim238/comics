<?php

namespace App\Versions\V1\Services;

use App\Dto\ChapterDto;
use App\Models\Chapter;
use App\Models\Manga;
use App\Models\Team;
use App\Versions\V1\Repositories\ChapterRepository;

class ChapterService
{
    private ChapterRepository $repository;

    public function __construct(
        private Chapter $chapter,
    ) {
        $this->repository = app(ChapterRepository::class, [
           'chapter' => $this->chapter
        ]);
    }

    public function store(ChapterDto $dto, Team $team, Manga $manga): Chapter
    {
        $this->repository
            ->fill($dto)
            ->associateTeam($team)
            ->associateManga($manga)
            ->save();

        return $this->chapter;
    }

    public function update(ChapterDto $dto): Chapter
    {
        $this->repository
            ->fill($dto)
            ->save();

        return $this->chapter;
    }

    public function delete(): void
    {
        $this->repository
            ->deleteMedia()
            ->delete();
    }
}
