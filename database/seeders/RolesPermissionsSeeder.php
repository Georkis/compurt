<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Create Roles
        $roleAdmin = Role::create(["name" => "Admin"]);
        $roleModerador = Role::create(["name" => "Moderador"]);
        $roleDev = Role::create(["name" => "Desarrollador"]);

        //Entity Roles
        $permissionCreateRole = Permission::create(["name" => "New role"]);
        $permissionReadRole = Permission::create(["name" => "Read role"]);
        $permissionUpdateRole = Permission::create(["name" => "Update role"]);
        $permissionDeleteRole = Permission::create(["name" => "Destroy role"]);

        //Entity User
        $permissionCreateUser = Permission::create(["name" => "New user"]);
        $permissionReadUser = Permission::create(["name" => "Read user"]);
        $permissionUpdateUser = Permission::create(["name" => "Update user"]);
        $permissionDeleteUser = Permission::create(["name" => "Destroy user"]);
        $permissionStatusUser = Permission::create(["name" => "Status user"]);

        //Entity Slider
        $permissionCreateSeccion = Permission::create(["name" => "New slider"]);
        $permissionReadSeccion = Permission::create(["name" => "Read slider"]);
        $permissionUpdateSeccion = Permission::create(["name" => "Update slider"]);
        $permissionDeleteSeccion = Permission::create(["name" => "Destroy slider"]);

        //Asignar Permisos
        $permissionsAdmin = [$permissionCreateRole,$permissionReadRole,$permissionUpdateRole,$permissionDeleteRole,
            $permissionCreateUser,$permissionReadUser,$permissionUpdateUser,$permissionDeleteUser,$permissionStatusUser,
            $permissionDeleteSeccion, $permissionCreateSeccion, $permissionReadSeccion, $permissionUpdateSeccion
        ];

        $roleAdmin->syncPermissions($permissionsAdmin);
    }
}
