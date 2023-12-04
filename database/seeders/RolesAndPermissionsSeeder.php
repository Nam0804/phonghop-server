<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'create-roles']);
        Permission::create(['name' => 'update-roles']);
        Permission::create(['name'=> 'show-roles']);

        $adminRole = Role::create(['name' => 'admin']);
        $managerRole = Role::create(['name' => 'manager']);
        $userRole = Role::create(['name' => 'user']);
        $guestRole = Role::create(['name' => 'guest']);

        $adminRole->givePermissionTo([
            'create-roles',
            'update-roles',
            'show-roles',
        ]);

        $userRole->givePermissionTo([
            'show-roles',
        ]);
        $managerRole->givePermissionTo([
            'update-roles',
            'show-roles',
        ]);
        $guestRole->givePermissionTo([
            'show-roles'
        ]);
    }
}
