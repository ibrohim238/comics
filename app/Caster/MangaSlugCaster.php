<?php

namespace App\Caster;

use App\Models\Manga;
use Spatie\DataTransferObject\Caster;

class MangaSlugCaster implements Caster
{
    public function cast(mixed $value): Manga
    {
        return Manga::firstWhere('slug', $value);
    }
}