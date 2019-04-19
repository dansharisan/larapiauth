<?php

use App\Enums\PermissionType;
use App\Enums\RoleType;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        /* Permissions */
        // Users
        Permission::create(['name' => PermissionType::VIEW_USERS]);
        Permission::create(['name' => PermissionType::CREATE_USERS]);
        Permission::create(['name' => PermissionType::UPDATE_USERS]);
        Permission::create(['name' => PermissionType::DELETE_USERS]);

        /* Roles */
        $userRole = Role::create(['name' => RoleType::Member]);
        $modRole = Role::create(['name' => RoleType::Moderator]);
        $modRole->givePermissionTo([
            PermissionType::VIEW_USERS,
            PermissionType::CREATE_USERS,
            PermissionType::UPDATE_USERS
        ]);
        $adminRole = Role::create(['name' => RoleType::Administrator]);
    }
}
