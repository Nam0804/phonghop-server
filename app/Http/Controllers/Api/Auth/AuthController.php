<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    use HttpResponses;
    public function login(LoginUserRequest $request){
        $request->validated($request->all());
        dd(Auth::manager());
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->input('password')])) {
            return $this->error('','Credentials not match email',401);
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
            'is_first_login'=> 0
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
    public function forgetPassword(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('email.forgetPassword', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });
        return $this->success('',[
            'message'=> 'We have e-mailed your password reset link!'
        ],200);

    }
    public function showResetPasswordForm($token) {
        return view('auth.forgetPasswordLink', ['token' => $token]);
    }
    public function submitResetPasswordForm(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_resets')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])
            ->first();

        if(!$updatePassword){
            return $this->error('',[
                'message'=>'Invalid token!'
            ],401);
        }
        // dd('hello');
        $user = User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email'=> $request->email])->delete();

        return $this->success('',[
            'message'=>'You have successfully changed password'
        ],200);
    }
}
