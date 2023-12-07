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
        Permission::create(['name' => 'show-company']);
        Permission::create(['name' => 'update-company']);
        Permission::create(['name'=> 'add-company']);
        Permission::create(['name'=> 'delete-company']);
        Permission::create(['name'=> 'show-all-company']);

        $adminRole = Role::create(['name' => 'manager']);
        $managerRole = Role::create(['name' => 'manager']);
        $userRole = Role::create(['name' => 'user']);
        $guestRole = Role::create(['name' => 'guest']);

        $adminRole->givePermissionTo([
            'show-company',
            'update-company',
            'add-company',
            'delete-company',
            'show-all-company'
        ]);

        $userRole->givePermissionTo([
            'show-all-company',
            'show-company'
        ]);
        $managerRole->givePermissionTo([
            'show-all-company',
            'show-company',
            'update-company'
        ]);
        $guestRole->givePermissionTo([
            'show-all-company'
        ]);
    }
}
