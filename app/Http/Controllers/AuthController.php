<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request) 
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $token = $user->createToken('token');
        return response()->json([
            'token' => $token->plainTextToken,
            'user' => $user
        ], 200);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        if (!Auth::attempt($data)) {
            return response([
                'password' => ['El email o el password son incorrectos']
            ], 422);
        }

        $user = Auth::user();
        return [
            'token' => $user->createToken('token')->plainTextToken,
            'user' => $user
        ];
    }


    public function logout(Request $request) 
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();
    
        return response()->json(['message' => 'Se cerro la sesión'], 200);
    }
}
