<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // get admin role
        $adminRole = Role::find(1);
        $userRole = Role::find(2);
        
        $usersPermissions = ['users-create','users-read','users-update','users-delete'];
        $projectsPermissions = ['projects-create','projects-read','projects-update','projects-delete'];
        // assign users permission to admin role
        foreach ($usersPermissions as $key => $item) {
            $permission = Permission::create(['name' => $item]);
            $adminRole->permissions()->attach($permission->id);
        }
        // assign projects permission to admin role
        foreach ($projectsPermissions as $key => $item) {
            $permission = Permission::create(['name' => $item]);
            $adminRole->permissions()->attach($permission->id);
        }
        // assign read project , update projct and read his profile for userRole
        $permissions  = Permission::whereIn('name',['users-read','users-update','projects-read','projects-update'])->pluck('id');
        $userRole->permissions()->attach($permissions);


    }
}
