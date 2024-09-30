<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request) {
       
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (!$user = User::where('name', $request->username)->first()) {
            return [
                'error' => 'Username not found!' 
            ];
        }

        if (!Hash::check($request->password, $user->password)) {
            return [
                'error' => 'Password does not match!'
            ];
        }

        $token = $user->createToken($user->name);
        return [
            'user' => $user,
            'token' => $token->plainTextToken
        ];
    }
    public function logout(Request $request) {

        $request->user()->tokens()->delete();

        return [
            'message' => 'You are logged out.'
        ];
    }
}
