<?php

namespace App\Swagger\Resources;

use App\Swagger\Models\InvoiceCreative;
use App\Swagger\Models\User;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'UserResource',
    description: 'User Resource',
    xml: new OA\Xml(
        name: 'User Resource'
    )
)]
class UserResource
{
    #[OA\Property(
        title: 'Data',
        description: 'Data wrapper'
    )]
    private User $user;
}
