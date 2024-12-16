<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponser;
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('auth_token')->accessToken;

        return $this->successResponse(['token' => $token], 201);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['email or password are invalid'], 401);
        }

        $token = Auth::user()->createToken('authToken')->accessToken;
        return response()->json(compact('token'));
    }

    public function logout(Request $request)
    {
        //revoke token laravel 11
        $request->user()->token()->revoke();
        return $this->successResponse(['message' => 'Successfully logged out'], 200);
    }

    public function refresh(Request $request)
    {
        $token = $request->user()->createToken('auth_token')->accessToken;
        return $this->successResponse(['token' => $token], 200);
    }
}
