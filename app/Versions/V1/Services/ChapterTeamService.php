<?php

namespace App\Versions\V1\Services;

use App\Models\Chapter;
use App\Models\ChapterTeam;
use App\Versions\V1\Dto\ChapterTeamDto;
use App\Versions\V1\Repository\ChapterTeamRepository;

class ChapterTeamService
{
    public ChapterTeamRepository $repository;

    public function __construct(
        private ChapterTeam $chapterTeam
    )
    {
        $this->repository = app(ChapterTeamRepository::class, [
            'chapterTeam' => $this->chapterTeam
        ]);
    }

    public function updateOrCreate(Chapter $chapter, ChapterTeamDto $dto): ChapterTeam
    {
        return $this->repository
            ->updateOrCreate(
                $this->prepareData($dto, $chapter)
            )->addMedia($dto->images)
            ->getChapter();
    }

    public function delete(): void
    {
        $this->repository
            ->deleteMedia()
            ->delete();
    }

    private function prepareData(
        ChapterTeamDto $dto,
        Chapter        $chapter,
    ): array
    {
        return [
            'attributes' => [
                'chapter_id' => $chapter->id,
                'team_id' => $dto->teamId,
            ],
            'values' => $dto->except('teamId', 'images')->toArray()
        ];
    }
}
