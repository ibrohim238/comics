<?php

namespace App\Swagger\Models;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'Manga',
    description: 'Manga Model',
    xml: new OA\Xml(
        name: 'Manga'
    )
)]
class Manga
{

    #[OA\Property(
        title: 'id',
        description: 'id',
        type: 'integer'
    )]
    public string $id;

    #[OA\Property(
        title: 'name',
        description: 'name',
        type: 'string'
    )]
    public string $name;

    #[OA\Property(
        title: 'slug',
        description: 'slug',
        type: 'string'
    )]
    public string $slug;

    #[OA\Property(
        title: 'description',
        description: 'description',
        type: 'string'
    )]
    public string $description;

    #[OA\Property(
        title: 'media',
        description: 'media',
        type: 'string'
    )]
    public string $media;

    #[OA\Property(
        title: 'tags',
        description: 'tags',
        type: 'string'
    )]
    public string $tags;

    #[OA\Property(
        title: 'rating',
        description: 'rating',
        type: 'string'
    )]
    public string $rating;

    #[OA\Property(
        title: 'ratings_count',
        description: 'ratings_count',
        type: 'string'
    )]
    public string $ratings_count;

    #[OA\Property(
        title: 'votes',
        description: 'votes',
        type: 'string'
    )]
    public string $votes;
}