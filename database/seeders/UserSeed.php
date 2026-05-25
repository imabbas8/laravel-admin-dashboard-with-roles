<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Organization;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organization = Organization::create([
            'name' => 'Mind Ora'
        ]);

        $user = User::create([
            'name' => 'Super Admin',
            'username' => 'admin',
            'email' => 'admin@mail.com',
            'organization_id' => $organization->id,
            'password' => bcrypt('admin@1234'),
        ]);
        $user->assignRole('super-admin');
        $role = Role::where('name', 'super-admin')->first();
        $role->syncPermissions(Permission::all());

        // $permissions = Permission::all();
        // foreach ($permissions as $key => $permission) {
        //     $user->givePermissionTo($permission->name);
        // }




        $user = User::create([
            'name' => 'test',
            'organization_id' => $organization->id,
            'username' => 'test',
            'email' => 'test@mail.com',
            'password' => bcrypt('test@123'),
        ]);

        $user->assignRole('admin');


        $role_admin = Role::where('name', 'admin')->first();
        $permissions = Permission::where('name', 'NOT LIKE', '%super%')->get();
        $role_admin->syncPermissions($permissions);

    //   foreach ($permissions as $key => $permission) {
    //     $user->givePermissionTo($permission->name);
    // }





    }
}
