<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Resources\AdminResource;
use App\Repository\AdminRepository\BaseAdminRepository;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AdminApiController extends Controller
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
        return $admins;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request)
    {
        $request->validated($request->all());
        $admin = $this->admin->create([
        'name' => $request->name,
        'email' => $request->email,
        'password'=> Hash::make($request->password),
        'role'=>$request->role,
        'phone'=>$request->phone,
        'company_id'=>$request->company_id,
        'is_first_login'=> 0]);
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
        $admin = $this ->admin->show($id);
        return $this->success([
            'data' => new AdminResource($admin),
            'message' => null,
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $admin = $this->admin->update($request->all(),$id);
        return $this->success([
            'data' => new AdminResource($admin),
            'message' => 'Admin updated successfully',
        ], 200);
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
    public function CompanyAdmins(string $company_id)
    {
        $admins = $this->admin->CompanyAdmins($company_id);
        return $this->success([
            'data' => AdminResource::collection($admins),
            'message' => null,
        ], 200);
    }
}
