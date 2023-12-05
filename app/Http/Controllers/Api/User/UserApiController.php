<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
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
            'company_id' => $request->company_id,
            'is_first_login' => 0
        ]);
        if ($user) {
            Mail::send('email.registerMail', ['email' => $request->email, 'password' => $request->password], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Register Password');
            });
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
        $user = $this->user->update($request->all(), $id);
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
}
