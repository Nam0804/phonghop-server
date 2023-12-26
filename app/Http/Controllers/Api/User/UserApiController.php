<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Mail\SendCreateMail;
use App\Repository\interface\BaseUserRepository;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $request->validated($request->all());
        $user = $this->user->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type,
            'phone' => $request->phone,
            'title' => $request->title,
            'company_id' => $request->company_id,
            'is_first_login' => 0,
        ]);
        if ($user) {
            Mail::to($user->email)->send(new SendCreateMail($user->email,$request->password, $user->name));
        }
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
        $user = $this->user->show($id);
        return $this->success([
            'data' => new UserResource($user),
            'message' => null,
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $update = $this->user->update($request->all(), $id);
        if($update){
            $user = $this->user->show($id);
            return $this->success([
                'data' => new UserResource($user),
                'message' => 'User updated successfully',
            ], 200);
        }
        else{
            return $this->error(null,'User not updated',400);
        }

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
    public function CompanyUsers(string $company_id)
    {
        $users = $this->user->CompanyUsers($company_id);
        return $this->success([
            'data' => UserResource::collection($users),
            'message' => null,
        ], 200);
    }
    public function confirmAccount($id)
    {
        $user = $this->user->confirmAccount($id);
        return $this->success([
            'data' => $user,
            'message' => 'Account confirmed successfully',
        ], 200);
    }
    public function verifyEmail($token)
    {
        $user = $this->user->confirmAccount($token);

        if (!$user) {
            return response()->json(['message' => 'Invalid verification token.'], 400);
        }

        return response()->json(['message' => 'Email verified successfully.'], 200);
    }

    public function changePassword(Request $request)
    {
        $user = $this->user->show($request->user_id);
        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();
            return $this->success([
                'data' => null,
                'message' => 'Password changed successfully',
            ], 200);
        } else {
            return $this->error(null, 'Old password is incorrect', 400);
        }
    }

// using the auth middleware to get the authenticated user
    public function profile()
    {
        $user = auth('sanctum')->user();
        if ($user) {
            return $this->success([
                'data' => new UserResource($user),
                'message' => null,
            ], 200);
        } else {
            return $this->error(null, 'User not found', 400);
        }
    }
    
}
