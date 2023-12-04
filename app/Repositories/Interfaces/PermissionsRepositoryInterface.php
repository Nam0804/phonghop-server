<?php

namespace App\Repositories\Interfaces;

interface PermissionsRepositoryInterface
{
    public function showPermissionByRole($role);
    public function updatePermission($role);
}
