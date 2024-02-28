<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $permisionsAll = Permission::all();

        foreach ($roles as $role){
            $permisions[] = [
                'name' => $role->name,
                'permissions' => $role->permissions
            ];
        }

        return Inertia::render(component: 'Role/Index', props: [
            'rolesPermissions' => $permisions,
            'permissions' =>  $permisionsAll
        ]);
    }
}
