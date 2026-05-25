<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;



class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $role = Role::create([
            'name' => 'super-admin',
            'organization_id' => 1
        ]);

        $routes = \Route::getRoutes();

        foreach ($routes as $route) {
            $str = strpos($route->getName(), "admin.");
            if ($str !== false) {
                $route_name = $route->getName();
                $permission = Permission::create(['name' => $route_name]);
            }
        }
        // $role->givePermissionTo($route_name);
        $role = Role::create([
            'name' => 'admin',
            'organization_id' => 1
        ]);
        $role = Role::create([
            'name' => 'user',
            'organization_id' => 1
        ]);


    }
}
