<?php

namespace App\Repository;

use App\Models\User;
use App\Repository\interface\RolesRepositoryInterface;
use Spatie\Permission\Models\Role;

class RolesRepository implements RolesRepositoryInterface
{
    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return Role::all();
    }

    public function assignRole($userName, $role): void
    {
        $role = Role::findByName($role);
        $newAssignedRole = User::where('name', $userName)->first();
        $newAssignedRole->assignRole($role);
    }

    public function createRole($role): \Spatie\Permission\Contracts\Role|Role
    {
        return Role::create(['name' => $role]);
    }

    public function showRole($user_id): \Illuminate\Support\Collection
    {
        $user = User::all()->find($user_id);
        return $user->getRoleNames();
    }

    public function updateRole($user_id, $role):void
    {
        $user = User::all()->find($user_id);
        $user->syncRoles([$role]);
    }
}
