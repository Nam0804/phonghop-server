<?php

namespace App\Repositories\Interfaces;

interface PermissionsRepositoryInterface
{
    public function index();
    public function showPermissionByRole($role);
}
