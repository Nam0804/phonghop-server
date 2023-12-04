<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PermissionsRepositoryInterface;
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

    public function updatePermission($role): void
    {
        $role->syncPermissions('new-permission');
    }
}
