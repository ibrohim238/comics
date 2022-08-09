<?php

namespace App\Versions\V1\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ChapterEventCollection extends ResourceCollection
{
    public $collects = ChapterEventResource::class;
}
