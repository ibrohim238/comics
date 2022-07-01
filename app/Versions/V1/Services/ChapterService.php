<?php

namespace App\Versions\V1\Services;

use App\Models\Chapter;
use App\Models\Manga;
use App\Versions\V1\Dto\ChapterDto;
use App\Versions\V1\Repository\ChapterRepository;

class ChapterService
{
    public ChapterRepository $repository;

    public function __construct(
        private Chapter $chapter,
    ) {
        $this->repository = app(ChapterRepository::class, [
           'chapter' => $this->chapter
        ]);
    }

    public function store(ChapterDto $dto, Manga $manga): Chapter
    {
        $this->repository
            ->fill($dto)
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
            ->deleteTeams()
            ->delete();
    }
}
