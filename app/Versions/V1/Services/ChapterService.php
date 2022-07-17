<?php

namespace App\Versions\V1\Services;

use App\Models\Chapter;
use App\Models\Manga;
use App\Models\Team;
use App\Versions\V1\Dto\ChapterDto;
use App\Versions\V1\Repositories\ChapterRepository;
use function app;

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

    public function store(ChapterDto $dto): Chapter
    {
        $this->repository
            ->fill($dto->toArray())
            ->associateTeam($dto->team_id)
            ->associateManga($dto->manga_id)
            ->save();

        return $this->chapter;
    }

    public function update(ChapterDto $dto): Chapter
    {
        $this->repository
            ->fill($dto->toArray())
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
