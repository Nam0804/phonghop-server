<?php

namespace App\Repository\interface;

use App\Models\User;

interface RolesRepositoryInterface
{
    public function index();
    public function assignRole($userName, $role);
    public function createRole($role);
    public function showRole($user);
    public function updateRole(User $user, $role);
}
