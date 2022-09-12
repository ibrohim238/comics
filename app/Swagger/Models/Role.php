<?php

namespace App\Swagger\Models;

use Carbon\Carbon;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'Role',
    description: 'Role Model',
    xml: new OA\Xml(
        name: 'Role'
    )
)]
class Role
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
        description: 'name',
        type: 'string',
    )]
    public string $name;

    #[OA\Property(
        title: 'permissions',
        description: 'permissions',
        type: 'array',
        items: new OA\Items(
            properties: [
                new OA\Property(
                    property: 'name',
                    title: 'name',
                    description: 'name',
                    type: 'string'

                )
            ]
        )
    )]
    public array $permissions;

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
