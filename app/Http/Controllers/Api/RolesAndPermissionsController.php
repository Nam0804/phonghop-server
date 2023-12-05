<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Interfaces\PermissionsRepositoryInterface;
use App\Repositories\Interfaces\RolesRepositoryInterface;
use App\Repositories\PermissionsRepository;

class RolesAndPermissionsController
{
    private PermissionsRepositoryInterface $permissionsRepository;
    private RolesRepositoryInterface $rolesRepository;

    function __construct(PermissionsRepositoryInterface $permissionsRepository,
                         RolesRepositoryInterface       $rolesRepository)
    {
        $this->permissionsRepository = $permissionsRepository;
        $this->rolesRepository = $rolesRepository;
    }

    public function index($request): \Illuminate\Http\JsonResponse
    {
        try{
            $permissions = $this->permissionsRepository->index();
            $role = $this->rolesRepository->index();
            $statusCode = 200;
        } catch (\Exception $e) {
            $permissions = null;
            $role = null;
            $statusCode = 500;
        }

        return response()->json([
            'permissions' => $permissions,
            'role' => $role
            ], $statusCode);
    }

    public function showRole($request){
        try{
            $roleByUser = $this->rolesRepository->showRole($request->user);
            $statusCode = 200;
        } catch (\Exception $e) {
            $roleByUser = null;
            $statusCode = 500;
        }
        $roleByUser = $this->rolesRepository->showRole($request->user);
        return response()->json(['roleByUser' => $roleByUser], $statusCode);
    }
    public function showPermissions($request): \Illuminate\Http\JsonResponse
    {
        try{
            $permissionList = $this->permissionsRepository->showPermissionByRole($request->role);
            $statusCode = 200;
        } catch (\Exception $e) {
            $permissionList = null;
            $statusCode = 500;
        }
        return response()->json(['permissionsByRole' => $permissionList], $statusCode);
    }

    public function createNewRole($request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->rolesRepository->createRole($request->role);
            $message = 'Role created successfully';
            $statusCode = 200;
        } catch (\Exception $e) {
            $message = 'Error creating new role';
            $statusCode = 500;
        }

        return response()->json([
            'message' => $message,
        ], $statusCode);
    }

    public function editRole($request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->rolesRepository->updateRole($request->user, $request->role);
            $role = $request->user->hasRole();
            $message = 'Role updated successfully';
            $statusCode = 200;
        } catch (\Exception $e) {
            $role = null;
            $message = 'Error updating role';
            $statusCode = 500;
        }

        return response()->json([
            'message' => $message,
            'role' => $role,
        ], $statusCode);
    }

}
