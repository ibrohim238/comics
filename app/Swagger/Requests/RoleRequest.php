<?php

namespace App\Swagger\Requests;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'Permission request',
    description: 'Permission request body data',
    required: [
        'name',
    ],
    type: 'object',
)]
class RoleRequest
{
    #[OA\Property(
        title: 'name',
        description: 'Название',
        type: 'string'
    )]
    public string $name;
}
