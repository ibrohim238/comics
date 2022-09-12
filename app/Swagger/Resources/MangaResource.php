<?php

namespace App\Swagger\Resources;

use App\Swagger\Models\Manga;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'MangaResource',
    description: 'Manga Resource',
    xml: new OA\Xml(
        name: 'Manga Resource'
    )
)]
class MangaResource
{
    #[OA\Property(
        title: 'Data',
        description: 'Data wrapper'
    )]
    private Manga $manga;
}
