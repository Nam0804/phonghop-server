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
        if(auth()->user()->can('show-admin-information')){
            $admins = $this->admin->list();

            return $this->success([
                'data' => AdminResource::collection($admins),
                'message' => 'Show Admins successfully',
            ], 200);
        }else{
            abort(403, 'You need permission to do this action.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request)
    {
        if(auth()->user()->can('add-new-admin')){
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
        }else{
            abort(403, 'You need permission to do this action.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(auth()->user()->can('show-admin-details-information')){
            $admin = $this->admin->show($id);
            return $this->success([
                'data' => new AdminResource($admin),
                'message' => 'Show Admin successfully',
            ], 201);
        }else{
            abort(403, 'You need permission to do this action.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(auth()->user()->can('update-admin-information')){
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
        }else{
            abort(403, 'You need permission to do this action.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(auth()->user()->can('delete-admin')){
            $admin = $this->admin->delete($id);
            return $this->success([
                'data' => null,
                'message' => 'Admin deleted successfully',
            ], 200);
        }else{
            abort(403, 'You need permission to do this action.');
        }
    }
}
