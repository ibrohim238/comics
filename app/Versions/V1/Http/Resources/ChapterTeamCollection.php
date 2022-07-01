<?php

namespace App\Versions\V1\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ChapterTeamCollection extends ResourceCollection
{
    public $collects = ChapterTeamResource::class;
}
