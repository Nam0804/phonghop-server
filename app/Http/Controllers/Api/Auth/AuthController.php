<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Mail\SendMail;
use App\Traits\HttpResponses;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Mockery\Exception;


class AuthController extends Controller
{
    use HttpResponses;
    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->input('password')])) {
            return $this->error('', 'Credentials not match email', 401);
        }
        $user = User::where('email', $request->email)->first();
        $user = $user->load('Company');
        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token')->plainTextToken,
        ],'Login successfully',200);
    }

    public function register(StoreUserRequest $request)
    {
        $request->validated($request->all());
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'title' => $request->title,
            'password' => Hash::make($request->password),
            'type' => $request->type,
            'phone' => $request->phone,
            'company_id' => $request->company_id,
            'is_first_login' => 1,
            'email_verified_token' => Str::random(30),
        ]);
        if ($user) {
            Mail::to($user->email)->send(new SendMail($user->email, $request->password, $user->email_verified_token));
            return $this->success([
                'user' => $user,
                'token' => $user->createToken('API Token')->plainTextToken,
            ], 'Register successfully',200);
        } else return $this->error("Can't register", null, 404);
    }

    public function logout()
    {
        try {
            Auth::user()->currentAccessToken()->delete();
            return $this->success(null,'You have successfully been logged out.',200);
        }
        catch (Exception $e){
            return $this->error(null,'Logged out error',400);
        }

    }

    public function forgetPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users',
            ]);

            $token = Str::random(64);

            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            Mail::send('email.forgetPassword', ['token' => $token], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Reset Password');
            });
            return $this->success('', [
                'message' => 'We have e-mailed your password reset link!'
            ], 200);
        }
        catch (Exception $e){
            return $this->error('', [
                'message' => 'Can not send you email. Something goes wrong!'
            ], 400);
        }

    }

    public function showResetPasswordForm($token)
    {
        return view('auth.forgetPasswordLink', ['token' => $token]);
    }

    public function submitResetPasswordForm(Request $request)
    {
        try {
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
    
            if (!$updatePassword) {
                return $this->error('', [
                    'message' => 'Invalid token!'
                ], 401);
            }
            $user = User::where('email', $request->email)
                ->update(['password' => Hash::make($request->password)]);
    
            DB::table('password_resets')->where(['email' => $request->email])->delete();
    
            return $this->success('', [
                'message' => 'You have successfully changed password'
            ], 200);
        } catch (\Throwable $th) {
            return $this->error('', [
                'message' => 'Can not change password. Something goes wrong!'
            ], 400);
        }

        
    }
}
