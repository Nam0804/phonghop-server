<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\RolesRepositoryInterface;
use Spatie\Permission\Models\Role;

class RolesRepository implements RolesRepositoryInterface
{
    public function index(){
        return Role::all();
    }

    public function createRole($role)
    {
        return Role::create(['name' => $role]);
    }

    public function updateRole($user, $role)
    {
        $user->syncRoles([$role]);
        return $user;
    }
}
