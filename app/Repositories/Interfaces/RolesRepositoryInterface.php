<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface RolesRepositoryInterface
{
    public function createRole($role);
    public function updateRole(User $user, $role);
}
