<?php

namespace App\Swagger\Resources;

use App\Swagger\Models\InvoiceCreative;
use App\Swagger\Models\Permission;
use App\Swagger\Models\User;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'PermissionResource',
    description: 'Permission Resource',
    xml: new OA\Xml(
        name: 'Permission Resource'
    )
)]
class PermissionResource
{
    #[OA\Property(
        title: 'Data',
        description: 'Data wrapper'
    )]
    private Permission $permission;
}
