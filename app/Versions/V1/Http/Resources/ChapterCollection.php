<?php

namespace App\Versions\V1\Http\Resources;


use Illuminate\Http\Resources\Json\ResourceCollection;

class ChapterCollection extends ResourceCollection
{
    public $collects = ChapterResource::class;
}
