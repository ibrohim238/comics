<?php

namespace App\Versions\V1\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TagCollection extends ResourceCollection
{
    public $collects = TagResource::class;
}
