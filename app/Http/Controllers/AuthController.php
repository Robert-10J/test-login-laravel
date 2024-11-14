<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

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

    public function login(RegisterRequest $request)
    {
        
    }


    public function logout(Request $request) 
    {

    }
}
