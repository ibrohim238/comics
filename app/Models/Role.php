<?php

namespace App\Models;

use App\Enums\RolePermissionEnum;
use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
    public static function firstOrCreateByPermission(RolePermissionEnum $role)
    {
        self::firstOrCreate(['name' => $role->value])
            ->givePermissionTo($role->permissions());
    }
}
