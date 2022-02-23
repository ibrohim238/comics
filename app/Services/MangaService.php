<?php

namespace App\Services;

use App\Dto\MangaDto;
use App\Models\Manga;

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
