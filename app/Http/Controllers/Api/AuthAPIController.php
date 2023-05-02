<?php

namespace App\Http\Controllers\Api;

// use Illuminate\Support\Facades\App

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthAPIController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'user' => auth()->user(),
                'token' => auth()->user()->createToken('authToken')->plainTextToken,
                'message' => 'Berhasil Login',
            ]);
        }

        throw ValidationException::withMessages([
            'email' => 'Invalid credentials',
        ]);

    }

    public function user_info(){
        $user = auth()->user();

        return response()->json(['user' => $user], 200);
    }

    public function logout()
    {
        if (auth()->check()) {
            $user = auth()->user();
            $user->currentAccessToken()->delete();
            return response()->json(['message' => 'Berhasil Logout']);
        } else {
            return response()->json(['message' => 'Anda harus login untuk menghapus token autentikasi']);
        }
    }
}
