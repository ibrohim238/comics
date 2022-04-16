<?php

namespace App\Versions\V1\Services;

use App\Models\Chapter;
use App\Models\Manga;
use App\Versions\V1\Dto\MangaDto;

class MangaService
{
    public function __construct(
        public Manga $manga,
    ) {
    }

    public function save(MangaDto $dto): Manga
    {
        $this->manga->fill($dto->toArray())->save();

        return $this->manga;
    }

    public function delete()
    {
        $this->manga->chapters()->each(function (Chapter $chapter) {
            (new ChapterService($chapter))->delete();
        });
        $this->manga->delete();
    }
}
