<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\ProyekController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function(Request $request) {
        return auth()->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/perusahaan',[PerusahaanController::class, 'store']);

    Route::get('/akun',[AkunController::class, 'index']);
    Route::get('/akun/{id}',[AkunController::class, 'show']);
    Route::post('/akun',[AkunController::class, 'store']);
    Route::put('/akun/{id}',[AkunController::class, 'update']);
    Route::delete('/akun/{id}',[AkunController::class, 'destroy']);


    Route::get('/proyek',[ProyekController::class, 'index']);
    Route::get('/proyek/{id}',[ProyekController::class, 'show']);
    Route::post('/proyek',[ProyekController::class, 'store']);
    Route::put('/proyek/{id}',[ProyekController::class, 'update']);
    Route::delete('/proyek/{id}',[ProyekController::class, 'destroy']);
});
