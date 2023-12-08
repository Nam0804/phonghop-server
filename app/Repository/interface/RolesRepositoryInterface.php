<?php

namespace App\Repository\interface;

use App\Models\User;

interface RolesRepositoryInterface
{
    public function index();
    public function assignRole($userName, $role);
    public function createRole($role);
    public function showRole($user_id);
    public function updateRole($user_id, $role);
}
