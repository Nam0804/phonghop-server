<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Resources\AdminResource;
use App\Repository\interface\BaseAdminRepository;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class  AdminApiController extends Controller
{
    use HttpResponses;

    protected $admin;
    public function __construct(BaseAdminRepository $admin)
    {
        $this->admin = $admin;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = $this->admin->list();

        return $this->success([
            'data' => AdminResource::collection($admins),
            'message' => 'Show Admins successfully',
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request)
    {
        $request->validated($request->all());
        $admin = $this->admin->create([
            'adm_name' => $request->adm_name,
            'adm_email' => $request->adm_email,
            'adm_phone' => $request->adm_phone,
            'adm_password' => Hash::make($request->adm_password),
            'adm_role' => $request->adm_role,
        ]);
        return $this->success([
            'data' => new AdminResource($admin),
            'message' => 'Admin created successfully',
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $admin = $this->admin->show($id);
        return $this->success([
            'data' => new AdminResource($admin),
            'message' => 'Show Admin successfully',
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $update = $this->admin->update($request->all(), $id);
        if ($update) {
            $admin = $this->admin->show($id);
            return $this->success([
                'data' => new AdminResource($admin),
                'message' => 'Admin updated successfully',
            ], 200);
        } else {
            return $this->error('','Admin not updated',400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = $this->admin->delete($id);
        return $this->success([
            'data' => null,
            'message' => 'Admin deleted successfully',
        ], 200);
    }
}
