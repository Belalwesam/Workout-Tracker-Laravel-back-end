<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;

class AuthController extends Controller
{

    #register function
    public function register(UserRegisterRequest $request)
    {
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $token = $user->createToken('access_token')->plainTextToken;
        return response()->json([
            'message' => 'user created successfully',
            'user' => $user,
            'token' => $token
        ]);
    }

    #login function
    public function login(UserLoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'invalid email or password',
                'status' => 401
            ]);
        } else {
            $token = $user->createToken('access_token')->plainTextToken;
            return response()->json([
                'message' => 'logged in successfully',
                'user' => $user,
                'token' => $token
            ]);
        }
    }

    #logout function
    public function logout() {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'logged out successfully'
        ]);
    }
}
