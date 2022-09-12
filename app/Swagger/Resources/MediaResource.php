<?php

namespace App\Swagger\Resources;

use App\Swagger\Models\Media;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'MediaResource',
    description: 'Media Resource',
    xml: new OA\Xml(
        name: 'Media Resource'
    )
)]
class MediaResource
{
    #[OA\Property(
        title: 'Data',
        description: 'Data wrapper'
    )]
    private Media $media;
}
