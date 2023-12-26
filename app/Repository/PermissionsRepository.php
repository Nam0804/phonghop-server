<?php

namespace App\Repository;

use App\Models\User;
use App\Repository\interface\PermissionsRepositoryInterface;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsRepository implements PermissionsRepositoryInterface
{

    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return Permission::all();
    }
    public function showPermissionByRole($user_id): \Illuminate\Support\Collection
    {
        $user = User::find($user_id);
        return $user->getAllPermissions();
    }

    public function updatePermissionByRole($role, array $permission):void
    {
        $role = Role::where('name', $role)->first();
        $role->syncPermissions([]);
        $role->givePermissionTo($permission);
    }
}
