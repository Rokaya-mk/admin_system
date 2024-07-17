<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\StoreRegister;
use App\Http\Requests\StorLogin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    public function register(StoreRegister $request)
    {
        // user store
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2,
        ]);
        $userData = User::where('email', $user->email)->first();
	    $success['name'] = $userData->name;
        // generate access token
        $success['token'] = $userData->createToken('@123*EMOOO*457##')->accessToken;
        return $this->SendResponse($success, 'Registered successfully');
    }

    public function login(StorLogin $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $success['name'] = $user->name;
            $success['token'] = $user->createToken('@123*EMOOO*457##')->accessToken;
            return $this->SendResponse($success, 'User logged in successfully');
        } else {
            return $this->SendError('Unauthorised', ['error', 'Unauthorised']);
        }
    }

    public function logout(Request $request)
    {
        if(auth()->check()){
            $request->user()->token()->revoke();
            return $this->SendResponse('User logout successfully', 200);
        }else{
            return $this->SendError('User doesn\'t logged in', 404);
        }
    }
    public function userProfile() {
        $user = User::with('role')->where('id',auth()->user()->id)->first();
        $userPermissions = $user->role->permissions;
        return response()->json([
            'user' => $user,
            'userPermissions' => $userPermissions,
        ]);
    }
}
