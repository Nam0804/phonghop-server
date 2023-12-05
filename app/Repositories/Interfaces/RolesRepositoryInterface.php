<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface RolesRepositoryInterface
{
    public function index();
    public function createRole($role);
    public function showRole($user);
    public function updateRole(User $user, $role);
}
