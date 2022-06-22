<?php

namespace App\Versions\V1\Actions;

use App\Models\Manga;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ShowMangaAction
{
    public function execute(Manga $manga): Manga
    {
        return $manga
            ->loadAvg('ratings', 'value');
    }
}
