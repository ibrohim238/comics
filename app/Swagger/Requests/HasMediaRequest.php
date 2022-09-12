<?php

namespace App\Swagger\Requests;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'Game request',
    description: 'Game request body data',
    required: [],
    type: 'object',
)]
class HasMediaRequest
{
    #[OA\Property(
        title: 'media',
        description: 'media',
        type: 'array',
        items: new OA\Items( type: 'file')
    )]
    public string $media;
}
