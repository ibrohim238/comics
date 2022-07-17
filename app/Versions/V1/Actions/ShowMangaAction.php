<?php

namespace App\Versions\V1\Actions;

use App\Models\Manga;

class ShowMangaAction
{
    public function execute(Manga $manga): Manga
    {
        return $manga
            ->loadAvg('ratings', 'value');
    }
}
