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

        Permission::create(['name' => 'show-meeting-rooms']);
        Permission::create(['name' => 'update-meeting-rooms']);
        Permission::create(['name'=> 'add-meeting-rooms']);
        Permission::create(['name'=> 'delete-meeting-rooms']);
        Permission::create(['name'=> 'show-all-meeting-rooms']);

        $adminRole = Role::create(['name' => 'admin']);
        $managerRole = Role::create(['name' => 'manager']);
        $userRole = Role::create(['name' => 'user']);
        $guestRole = Role::create(['name' => 'guest']);

        $adminRole->givePermissionTo([
            'show-company',
            'update-company',
            'add-company',
            'delete-company',
            'show-all-company',
            'update-meeting-rooms',
            'add-meeting-rooms',
            'delete-meeting-rooms',
            'show-meeting-rooms',
            'show-all-meeting-rooms'
        ]);

        $userRole->givePermissionTo([
            'show-all-company',
            'show-company',
            'show-meeting-rooms',
            'show-all-meeting-rooms'
        ]);
        $managerRole->givePermissionTo([
            'show-all-company',
            'show-company',
            'update-company',
            'show-meeting-rooms',
            'show-all-meeting-rooms',
            'update-meeting-rooms'
        ]);
        $guestRole->givePermissionTo([
            'show-all-company',
            'show-all-meeting-rooms'
        ]);
    }
}
