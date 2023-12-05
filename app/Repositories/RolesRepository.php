<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\RolesRepositoryInterface;
use Spatie\Permission\Models\Role;

class RolesRepository implements RolesRepositoryInterface
{
    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return Role::all();
    }

    public function assignRole(User $user, $role): void
    {
        $role = Role::findByName($role);
        $user->assignRole($role);
    }

    public function createRole($role): \Spatie\Permission\Contracts\Role|Role
    {
        return Role::create(['name' => $role]);
    }

    public function showRole($user)
    {
        return $user->getRoleNames();
    }

    public function updateRole($user, $role):void
    {
        $user->syncRoles([$role]);
    }
}
