<?php

namespace App\Versions\V1\Services;

use App\Models\Manga;
use App\Versions\V1\Dto\MangaDto;

class MangaService
{
    public function save(Manga $manga, MangaDto $dto)
    {
        $manga->fill($dto->toArray());

        return $manga;
    }

    public function delete(Manga $manga)
    {
        $manga->delete();
    }
}
