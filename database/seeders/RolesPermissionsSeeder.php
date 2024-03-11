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

        //Entity Contact Data
        $permissionReadContactData = Permission::create(['name' => 'Read contact']);
        $permissionUpdateContactData = Permission::create(['name' => 'Update contact']);

        //Entity About
        $permissionCreateAbout = Permission::create(['name' => 'Create about']);
        $permissionReadAbout = Permission::create(['name' => 'Read about']);
        $permissionUpdateAbout = Permission::create(['name' => 'Update about']);
        $permissionDeleteAbout = Permission::create(['name' => 'Destroy about']);

        //Entity Service
        $permissionCreateService = Permission::create(['name' => 'Create service']);
        $permissionReadService = Permission::create(['name' => 'Read service']);
        $permissionUpdateService = Permission::create(['name' => 'Update service']);
        $permissionDeleteService = Permission::create(['name' => 'Destroy service']);

        //Entity Testimonial
        $permissionCreateTestimonial = Permission::create(['name' => 'Create testimonial']);
        $permissionReadTestimonial = Permission::create(['name' => 'Read testimonial']);
        $permissionUpdateTestimonial = Permission::create(['name' => 'Update testimonial']);
        $permissionDeleteTestimonial = Permission::create(['name' => 'Destroy testimonial']);

        //Entity SocialNets
        $permissionReadSocialNet = Permission::create(['name' => 'Read social net']);
        $permissionUpdateSocialNet = Permission::create(['name' => 'Update social net']);

        //Asignar Permisos
        $permissionsAdmin = [$permissionCreateRole,$permissionReadRole,$permissionUpdateRole,$permissionDeleteRole,
            $permissionCreateUser,$permissionReadUser,$permissionUpdateUser,$permissionDeleteUser,$permissionStatusUser,
            $permissionDeleteSeccion, $permissionCreateSeccion, $permissionReadSeccion, $permissionUpdateSeccion,
            $permissionUpdateContactData, $permissionReadContactData, $permissionCreateAbout, $permissionReadAbout, $permissionUpdateAbout,
            $permissionDeleteAbout, $permissionCreateService, $permissionReadService, $permissionUpdateService, $permissionDeleteService,
            $permissionCreateTestimonial, $permissionReadTestimonial, $permissionUpdateTestimonial, $permissionDeleteTestimonial,
            $permissionReadSocialNet, $permissionUpdateSocialNet
        ];

        $roleAdmin->syncPermissions($permissionsAdmin);
    }
}
