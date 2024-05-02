<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;

class AuthController extends Controller
{
    use HttpResponses;

    /*
    * login via email address and password 
    */
    public function login(LoginUserRequest $request)
    {
        try {
            $request->validated($request->all());
            if (!auth()->attempt($request->only(['email', 'password']))) {
                return $this->error('', 'Credentails are not matched...!', 401);
            }
            return $this->success(['user' => auth()->user(), 'token' => auth()->user()->createToken('API Token of ' . auth()->user()->username)->plainTextToken]);
        } catch (\Throwable $th) {
            return $this->error('', $th, 401);
        }      
    }

    /*
    * register new user via name, email address and password 
    */
    public function register(StoreUserRequest $request)
    {
        try {
            $request->validated($request->all());
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => $request->password,
            ]);
            return $this->success([
                'user' => $user,
                'token' => $user->createToken('API Token of ' . $user->username)->plainTextToken,
            ], "User created Successfully...!");
        } catch (\Throwable $th) {
            return $this->error('', $th, 401);
        }  
    }

    /*
    * logout existing logged in user
    */
    public function logout()
    {
        try {
            auth()->user()->currentAccessToken()->delete();
            return $this->success("", "User logout successfully...!", 200);
        } catch (\Throwable $th) {
            return $this->error('', $th, 401);
        }
    }

    /*
    * Refresh token on basis of old token verification and generate new token
    */
    public function refresh(Request $request)
    {
        try {
            $user = $request->user();
            $user->tokens()->delete();
            return $this->success(['token' => $user->createToken('API Token of ' . auth()->user()->username)->plainTextToken], 'Token refresh successfully...!');
        } catch (\Throwable $th) {
            return $this->error('', $th, 401);
        }
    }

    public function delete($id)
    {
        try {
            $user_count = User::where('id', $id)->count();

            if($user_count <= 0) {
                return $this->error([], "User Not Found...!");
            }
            $user = User::where('id', $id)->delete();
            
            return $this->success([
                'user' => null,
            ], "User Deleted Successfully...!");
        } catch (\Exception $th) {
            return $this->error('', $th, 400);
        }
    }

}