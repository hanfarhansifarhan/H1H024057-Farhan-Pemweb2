<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register
    |--------------------------------------------------------------------------
    */

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'peran' => 'mahasiswa',
        ]);

        $token = $user->createToken(
            'token-api',
            ['mahasiswa:baca']
        )->plainTextToken;

        return response()->json([
            'sukses' => true,
            'pesan' => 'Registrasi berhasil',
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        // Menyimpan waktu login terakhir
        $user->terakhir_login = now();
        $user->save();

        // Menentukan ability berdasarkan peran
        if ($user->peran === 'admin') {
            $abilities = [
                'mahasiswa:baca',
                'mahasiswa:tulis',
            ];
        } else {
            $abilities = [
                'mahasiswa:baca',
            ];
        }

        $token = $user->createToken(
            'token-api',
            $abilities
        )->plainTextToken;

        return response()->json([
            'sukses' => true,
            'pesan' => 'Login berhasil',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'peran' => $user->peran,
                    'terakhir_login' => $user->terakhir_login,
                ],
                'token' => $token,
            ],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Profil User
    |--------------------------------------------------------------------------
    */

    public function me(Request $request)
    {
        return response()->json([
            'sukses' => true,
            'data' => [
                'user' => $request->user(),
            ],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Logout Token yang Sedang Digunakan
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'sukses' => true,
            'pesan' => 'Logout berhasil',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Logout Semua Token
    |--------------------------------------------------------------------------
    */

    public function logoutSemua(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'sukses' => true,
            'pesan' => 'Logout dari semua perangkat berhasil',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Ubah Password
    |--------------------------------------------------------------------------
    */

    public function ubahPassword(Request $request)
    {
        $data = $request->validate([
            'password_lama' => ['required', 'string'],
            'password_baru' => ['required', 'string', 'min:8'],
        ]);

        $user = $request->user();

        if (!Hash::check($data['password_lama'], $user->password)) {
            return response()->json([
                'sukses' => false,
                'pesan' => 'Password lama tidak sesuai',
            ], 422);
        }

        $user->password = Hash::make($data['password_baru']);
        $user->save();

        return response()->json([
            'sukses' => true,
            'pesan' => 'Password berhasil diubah',
        ]);
    }
}