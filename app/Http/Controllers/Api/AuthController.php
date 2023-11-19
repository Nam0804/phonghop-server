<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Traits\HttpResponses;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    use HttpResponses;
    public function login(LoginUserRequest $request){
        $request->validated($request->all());
        if(!Auth::attempt([$request->only('email','password')])){
            return $this->error('','Credentials not match',401);
        }
        $user = User::where('email',$request->email)->first();
        return $this->success([
            'user'=>$user,
            'token'=> $user->createToken('API Token')->plainTextToken,
        ]);
    }
    public function register(StoreUserRequest $request){
        $request->validated($request->all());
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password'=> Hash::make($request->password),
            'role'=>2,
        ]);
        return $this->success([
            'user'=>$user,
            'token'=> $user->createToken('API Token')->plainTextToken,
        ]);
    }
    public function logout(){
        Auth::user()->currentAccessToken()->delete();
        return $this->success([
            'message'=>'You have successfully been logged out.'
        ]);
    }
    public function forgotPassword(Request $request){
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }
}
