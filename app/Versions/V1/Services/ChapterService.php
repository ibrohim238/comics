<?php

namespace App\Versions\V1\Services;

use App\Models\Chapter;
use App\Versions\V1\Dto\ChapterDto;

class ChapterService
{
    public function __construct(
        public Chapter $chapter,
    ) {
    }

    public function save(ChapterDto $dto): Chapter
    {
        $this->chapter->fill($dto->toArray())->save();

        return $this->chapter;
    }

    public function delete()
    {
        $this->chapter->delete();
    }
}
