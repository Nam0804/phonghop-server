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

        Permission::create(['name'=> 'add-new-users']);
        Permission::create(['name' => 'update-user-information']);
        Permission::create(['name' => 'show-users-information']);
        Permission::create(['name' => 'show-users-details-information']);
        Permission::create(['name'=> 'delete-user']);

        Permission::create(['name'=> 'add-new-admin']);
        Permission::create(['name' => 'update-admin-information']);
        Permission::create(['name' => 'show-admin-information']);
        Permission::create(['name' => 'show-admin-details-information']);
        Permission::create(['name'=> 'delete-admin']);

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
            'show-all-meeting-rooms',
            'add-new-users',
            'update-user-information',
            'show-users-information',
            'show-users-details-information',
            'delete-user',
            'add-new-admin',
            'update-admin-information',
            'show-admin-information',
            'show-admin-details-information',
            'delete-admin'
        ]);

        $userRole->givePermissionTo([
            'show-all-company',
            'show-company',
            'add-meeting-rooms',
            'show-meeting-rooms',
            'show-all-meeting-rooms',
            'show-users-information',
            'show-users-details-information',
            'update-user-information'
        ]);
        $managerRole->givePermissionTo([
            'show-all-company',
            'show-company',
            'update-company',
            'add-meeting-rooms',
            'show-meeting-rooms',
            'show-all-meeting-rooms',
            'update-meeting-rooms',
            'update-user-information',
            'show-users-information',
            'show-users-details-information'
        ]);
        $guestRole->givePermissionTo([
            'show-all-company',
            'add-meeting-rooms',
            'show-all-meeting-rooms',
        ]);
    }
}
