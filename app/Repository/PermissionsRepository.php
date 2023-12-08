<?php

namespace App\Repository;

use App\Repository\interface\PermissionsRepositoryInterface;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsRepository implements PermissionsRepositoryInterface
{

    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return Permission::all();
    }
    public function showPermissionByRole($role): \Illuminate\Support\Collection
    {
        $role = Role::findByName($role);
        return $role->permissions;
    }

    public function updatePermissionByRole($role, array $permission):void
    {
        $role = Role::where('name', $role)->first();
        $role->syncPermissions([]);
        $role->givePermissionTo($permission);
    }
}
