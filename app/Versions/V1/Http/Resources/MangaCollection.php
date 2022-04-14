<?php

namespace App\Versions\V1\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MangaCollection extends ResourceCollection
{
    public $collects = MangaResource::class;
}
