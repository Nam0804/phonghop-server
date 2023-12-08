<?php

namespace App\Repository\interface;

interface PermissionsRepositoryInterface
{
    public function index();
    public function showPermissionByRole($user_id);
}
