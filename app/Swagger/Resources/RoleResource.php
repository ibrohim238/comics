<?php

namespace App\Swagger\Resources;

use App\Swagger\Models\InvoiceCreative;
use App\Swagger\Models\Role;
use App\Swagger\Models\User;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'RoleResource',
    description: 'Role Resource',
    xml: new OA\Xml(
        name: 'Role Resource'
    )
)]
class RoleResource
{
    #[OA\Property(
        title: 'Data',
        description: 'Data wrapper'
    )]
    private Role $role;
}
