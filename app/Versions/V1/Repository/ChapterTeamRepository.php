<?php

namespace App\Versions\V1\Repository;

use App\Models\Chapter;
use App\Models\ChapterTeam;
use App\Models\Team;
use App\Versions\V1\Dto\ChapterTeamDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ChapterTeamRepository
{
    public function __construct(
        private ChapterTeam $chapterTeam
    ) {
    }

    public function paginate(?int $perPage): LengthAwarePaginator
    {
        return QueryBuilder::for($this->chapterTeam)
            ->with('chapter')
            ->allowedFilters(
                AllowedFilter::exact('volume', 'chapter.volume'),
                AllowedFilter::exact('number', 'chapter.number'),
            )->paginate($perPage);
    }

    public function load(): static
    {
        $this->chapterTeam->load('chapter');

        return  $this;
    }

    public function getChapter(): ChapterTeam
    {
        return $this->chapterTeam;
    }

    public function updateOrCreate(array $data): static
    {
        $this->chapterTeam = $this->chapterTeam
            ->updateOrCreate(
                $data['attributes'],
                $data['values']
            );

        return $this;
    }

    public function addMedia(?array $images): static
    {
        if (! empty($images)) {
            $this->chapterTeam->clearMediaCollection();
            $this->chapterTeam->addMultipleMediaFromRequest(['images'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection();
                });
        }

        return $this;
    }

    public function deleteMedia(): static
    {
        $this->chapterTeam->clearMediaCollection();

        return $this;
    }

    public function delete(): static
    {
        $this->chapterTeam->delete();

        return $this;
    }
}
