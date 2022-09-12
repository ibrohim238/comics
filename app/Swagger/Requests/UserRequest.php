<?php

namespace App\Swagger\Requests;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'User request',
    description: 'User request body data',
    required: [
        'name',
        'last_name',
        'email',
        'password',
    ],
    type: 'object',
)]
class UserRequest
{
    #[OA\Property(
        title: 'name',
        description: 'Название',
        type: 'string'
    )]
    public string $name;

    #[OA\Property(
        title: 'last_name',
        description: 'last_name',
        type: 'string'
    )]
    public string $last_name;

    #[OA\Property(
        title: 'email',
        description: 'email',
        type: 'string'
    )]
    public string $email;

    #[OA\Property(
        title: 'password',
        description: 'password',
        type: 'string'
    )]
    public string $password;
}
