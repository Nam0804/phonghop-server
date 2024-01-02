<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Repository\PermissionsRepository;
use App\Repository\RolesRepository;
use Illuminate\Http\Request;

class RolesAndPermissionsController
{
    private PermissionsRepository $permissionsRepository;
    private RolesRepository $rolesRepository;

    function __construct(PermissionsRepository $permissionsRepository,
        RolesRepository $rolesRepository)
    {
        $this->permissionsRepository = $permissionsRepository;
        $this->rolesRepository = $rolesRepository;
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
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

    public function assignRole(): \Illuminate\Http\JsonResponse
    {
        /** 
         * Bước 1: Trước khi chạy hàm assignRole cần chạy migrate db và sau đó chạy php artisan db:seed RolesAndPermissionsSeeder
         * Bước 2: Pass user name vào trong hàm assignRole() để gán quyền cho user
         * **/

        try {
            $this->rolesRepository->assignRole(2, 'user');
             $this->rolesRepository->assignRole(0, 'admin');
           $this->rolesRepository->assignRole(1, 'manager');
 //           $this->rolesRepository->assignRole('guest', 'guest');
                    //    $user = User::where('name','trung')->first();
        //    $role = $user->getRoleNames();
        //    dd($role);
            $message = 'Role assigned successfully';
            $statusCode = 200;
        } catch (\Exception $e) {
            //            $role = null;
            $statusCode = 500;
            $message = 'Role assigned failed';
        }
        return response()->json([
            //            'role' => $role,
            'message' => $message,
        ], $statusCode);
    }

    public function showRole($request): \Illuminate\Http\JsonResponse
    {
        try {
            $roleByUser = $this->rolesRepository->showRole($request->user_id);
            $statusCode = 200;
        } catch (\Exception $e) {
            $roleByUser = null;
            $statusCode = 500;
        }
        $roleByUser = $this->rolesRepository->showRole($request->user);
        return response()->json(['roleByUser' => $roleByUser], $statusCode);
    }
    public function showPermissions(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $permissionList = $this->permissionsRepository->showPermissionByRole($request->user_id);
            $statusCode = 200;
        } catch (\Exception $e) {
            $permissionList = null;
            $statusCode = 500;
        }
        return response()->json(['permissionsByRole' => $permissionList], $statusCode);
    }

    public function createNewRole(Request $request): \Illuminate\Http\JsonResponse
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

    public function editRole(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->rolesRepository->updateRole($request->user_id, $request->role);
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

    public function updatePermissions(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->permissionsRepository->updatePermissionByRole($request->role, $request->permissions);
            $message = 'permissions updated successfully';
            $statusCode = 200;
        } catch (\Exception $e) {
            $message = 'Error updating permissions';
            $statusCode = 500;
        }

        return response()->json([
            'message' => $message,
        ], $statusCode);
    }
}
