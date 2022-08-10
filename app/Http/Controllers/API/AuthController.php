<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request){
        // Ambil user dimana emailnya = email yang di input
        $user = User::where('email', $request->email)->first();

        // Jika user tidak ada atau password yang di input != password yang diambil
        // Maka kembalikan pesan UNAUTHORIZED (401)
        if(!$user || !\Hash::check($request->password, $user->password)){
            return response()->json([
                'message' => 'UNAUTHORIZED'
            ], 401);
        }

        // Jika Berhasil Create Token
        $token = $user->createToken('token-name')->plainTextToken;

        // Lalu kembalikan pesan berhasil
        return response()->json([
            'message' => 'success',
            'user' => $user,
            'token' => $token
        ], 200);
    }

    public function logout(Request $request){
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Berhasil Logout'
        ], 200);
    }
}
