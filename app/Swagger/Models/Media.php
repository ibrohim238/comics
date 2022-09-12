<?php

namespace App\Swagger\Models;

use Carbon\Carbon;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'Media',
    description: 'Media Model',
    xml: new OA\Xml(
        name: 'Media'
    )
)]
class Media
{
    #[OA\Property(
        title: 'id',
        description: 'Идентификатор',
        format: 'int64',
        example: 1,
    )]
    private int $id;

    #[OA\Property(
        title: 'name',
        description: 'Название',
        example: 'Владимир'
    )]
    public string $name;

    #[OA\Property(
        title: 'collection_name',
        description: 'collection name',
        example: 'default'
    )]
    public string $collection_name;

    #[OA\Property(
        title: 'disk',
        description: 'disk',
        example: 'public'
    )]
    public string $disk;

    #[OA\Property(
        title: 'url',
        description: 'url',
        example: 'http://localhost'
    )]
    public string $url;

    #[OA\Property(
        title: "Created at",
        description: "Создана в",
        type: "string",
        format: "datetime",
        example: "2020-01-27 17:50:45",
    )]
    private Carbon $created_at;

    #[OA\Property(
        title: "Updated at",
        description: "Обновлена в",
        type: "string",
        format: "datetime",
        example: "2020-01-27 17:50:45",
    )]
    private Carbon $updated_at;
}
