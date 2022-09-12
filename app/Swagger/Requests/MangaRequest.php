<?php

namespace App\Swagger\Requests;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'Manga request',
    description: 'Manga request body data',
    required: [
        'name',
        'description',
        'tags',
    ],
    type: 'object',
)]
class MangaRequest
{
    #[OA\Property(
        title: 'name',
        description: 'name',
        type: 'string'
    )]
    public string $name;

    #[OA\Property(
        title: 'description',
        description: 'description',
        type: 'string'
    )]
    public string $description;

    #[OA\Property(
        title: 'published_at',
        description: 'published_at',
        type: 'string'
    )]
    public string $published_at;

    #[OA\Property(
        title: 'tags',
        description: 'tags',
        type: 'array',
        items: new OA\Items(
            type: 'integer'
        )
    )]
    public array $tags;

    #[OA\Property(
        title: 'media',
        description: 'media',
        type: 'string'
    )]
    public string $media;
}