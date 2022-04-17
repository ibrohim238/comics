<?php

namespace Database\Seeders;

use App\Enums\PermissionEnum;
use App\Enums\RolePermissionEnum;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = PermissionEnum::values();
        $roles = RolePermissionEnum::cases();
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        foreach ($roles as $role) {
            Role::firstOrCreateByPermission($role);
        }
    }
}
