<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MahasiswaController;
use App\Http\Controllers\Api\MatakuliahController;
use App\Http\Controllers\Api\ProgramStudiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Status API
|--------------------------------------------------------------------------
*/

Route::get('/status', function () {
    return response()->json([
        'sukses' => true,
        'pesan' => 'API Pemweb II aktif',
        'waktu' => now()->toIso8601String(),
    ]);
});


/*
|--------------------------------------------------------------------------
| Autentikasi Tanpa Token
|--------------------------------------------------------------------------
*/

Route::post('/auth/register', [
    AuthController::class,
    'register'
]);

Route::post('/auth/login', [
    AuthController::class,
    'login'
]);


/*
|--------------------------------------------------------------------------
| Route yang Membutuhkan Autentikasi Sanctum
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Profil
    |--------------------------------------------------------------------------
    */

    Route::get('/auth/profil', [
        AuthController::class,
        'me'
    ]);


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    Route::post('/auth/logout', [
        AuthController::class,
        'logout'
    ]);


    /*
    |--------------------------------------------------------------------------
    | Logout Semua Token
    |--------------------------------------------------------------------------
    */

    Route::post('/auth/logout-semua', [
        AuthController::class,
        'logoutSemua'
    ]);


    /*
    |--------------------------------------------------------------------------
    | Ubah Password
    |--------------------------------------------------------------------------
    */

    Route::put('/auth/password', [
        AuthController::class,
        'ubahPassword'
    ]);


    /*
    |--------------------------------------------------------------------------
    | Mahasiswa - GET
    |--------------------------------------------------------------------------
    */

    Route::get('/mahasiswa', [
        MahasiswaController::class,
        'index'
    ]);

    Route::get('/mahasiswa/{mahasiswa}', [
        MahasiswaController::class,
        'show'
    ]);


    /*
    |--------------------------------------------------------------------------
    | Mahasiswa - Tambah, Update, Hapus
    | Membutuhkan ability mahasiswa:tulis
    |--------------------------------------------------------------------------
    */

    Route::middleware('ability:mahasiswa:tulis')->group(function () {

        Route::post('/mahasiswa', [
            MahasiswaController::class,
            'store'
        ]);

        Route::put('/mahasiswa/{mahasiswa}', [
            MahasiswaController::class,
            'update'
        ]);

        Route::patch('/mahasiswa/{mahasiswa}', [
            MahasiswaController::class,
            'update'
        ]);

        Route::delete('/mahasiswa/{mahasiswa}', [
            MahasiswaController::class,
            'destroy'
        ]);
    });


    /*
    |--------------------------------------------------------------------------
    | Matakuliah
    |--------------------------------------------------------------------------
    */

    Route::apiResource(
        'matakuliah',
        MatakuliahController::class
    );


    /*
    |--------------------------------------------------------------------------
    | Mahasiswa berdasarkan Program Studi
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/program-studi/{id}/mahasiswa',
        [ProgramStudiController::class, 'mahasiswa']
    );
});