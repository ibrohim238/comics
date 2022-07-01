<?php

namespace App\Versions\V1\Services;

use App\Models\Chapter;
use App\Models\ChapterTeam;
use App\Models\Team;
use App\Versions\V1\Dto\ChapterTeamDto;
use App\Versions\V1\Repository\ChapterTeamRepository;

class ChapterTeamService
{
    public ChapterTeamRepository $repository;

    public function __construct(
        private ChapterTeam $chapterTeam
    ) {
        $this->repository = app(ChapterTeamRepository::class, [
           'chapterTeam' => $this->chapterTeam
        ]);
    }

    public function create(Chapter $chapter, Team $team, ChapterTeamDto $dto): ChapterTeam
    {
        $this->repository
            ->fill($dto)
            ->associateTeam($team)
            ->associateChapter($chapter)
            ->save()
            ->addMedia($dto->images);

        return $this->chapterTeam;
    }

    public function update(ChapterTeamDto $dto): ChapterTeam
    {
        $this->repository
            ->fill($dto)
            ->save()
            ->addMedia($dto->images);

        return $this->chapterTeam;
    }

    public function delete(): void
    {
        $this->repository
            ->deleteMedia()
            ->delete();
    }
}
