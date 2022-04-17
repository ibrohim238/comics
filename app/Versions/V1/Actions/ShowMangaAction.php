<?php

namespace App\Versions\V1\Actions;

use App\Models\Manga;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ShowMangaAction
{
    public function execute(Manga $manga): Manga
    {
        return $manga
            ->load([
                'comments' => fn (MorphMany $query) => $query->limit(3),
                'chapters'
            ])
            ->loadAvg('ratings', 'rating');
    }
}
