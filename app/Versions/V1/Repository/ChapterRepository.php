<?php

namespace App\Versions\V1\Repository;

use App\Models\Chapter;
use App\Models\ChapterTeam;
use App\Models\Manga;
use App\Models\Team;
use App\Versions\V1\Dto\ChapterDto;
use App\Versions\V1\Services\ChapterTeamService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ChapterRepository
{
    public function __construct(
        private Chapter $chapter
    ) {
    }

    public function paginateChapterTeam(?int $perPage): LengthAwarePaginator
    {
        return QueryBuilder::for($this->chapter->chapterTeams())
            ->with('chapter')
            ->allowedFilters(
                AllowedFilter::exact('volume', 'chapter.volume'),
                AllowedFilter::exact('number', 'chapter.number'),
            )->paginate($perPage);
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

    public function associateManga(Manga $manga): static
    {
        $this->chapter->manga()->associate($manga);

        return $this;
    }

    public function deleteTeams(): static
    {
        $this->chapter->chapterTeams()->each(function (ChapterTeam $chapterTeam) {
            app(ChapterTeamService::class, [
                'chapterTeam' => $chapterTeam
            ])->delete();
        });

        return $this;
    }

    public function delete(): static
    {
        $this->chapter->delete();

        return $this;
    }
}
