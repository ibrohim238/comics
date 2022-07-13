<?php

namespace App\Versions\V1\Repositories;

use App\Models\ChapterTeam;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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

    public function getChapterTeam(): ChapterTeam
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
