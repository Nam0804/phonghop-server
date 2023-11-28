<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use App\Repository\BaseUserRepository;
use Illuminate\Support\Facades\Hash;


class UserApiController extends Controller
{
    use HttpResponses;

    protected $user;
    public function __construct(BaseUserRepository $user)
    {
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->user->list();
        return $users;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $request->validated($request->all());
        $user = $this->user->create([
        'name' => $request->name,
        'email' => $request->email,
        'password'=> Hash::make($request->password),
        'role'=>2,
        'company_id'=>$request->company_id,
        'is_first_login'=> 0]);
        return $this->success([
            'data' => new UserResource($user),
            'message' => 'User created successfully',
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = $this ->user->show($id);
        return $this->success([
            'data' => new UserResource($user),
            'message' => null,
        ], 201);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = $this->user->update($request->all(),$id);
        return $this->success([
            'data' => new UserResource($user),
            'message' => 'User updated successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = $this->user->delete($id);
        return $this->success([
            'data' => null,
            'message' => 'User deleted successfully',
        ], 200);
    }
}
