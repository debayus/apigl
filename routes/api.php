<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\KonsepAkunController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\StrukturAkunController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/profile', fn() => auth()->user());

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/perusahaan',[PerusahaanController::class, 'store']);
    Route::get('/user',[UserController::class, 'index']);

    Route::prefix('/akun')->controller(AkunController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/','store');
        Route::put('/{id}','update');
        Route::delete('/{id}', 'destroy');
    });

    Route::prefix('/proyek')->controller(ProyekController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/','store');
        Route::put('/{id}','update');
        Route::delete('/{id}', 'destroy');
    });

    Route::prefix('/kontak')->controller(KontakController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/','store');
        Route::put('/{id}','update');
        Route::delete('/{id}', 'destroy');
    });

    Route::prefix('/strukturAkun')->controller(StrukturAkunController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/','store');
        Route::put('/{id}','update');
        Route::delete('/{id}', 'destroy');
    });

    Route::prefix('/konsepAkun')->controller(KonsepAkunController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/','store');
        Route::put('/{id}','update');
        Route::delete('/{id}', 'destroy');
    });

    Route::prefix('/akun')->controller(AkunController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/','store');
        Route::put('/{id}','update');
        Route::delete('/{id}', 'destroy');
    });

    Route::get('/akunMaster',[AkunController::class, 'master']);
    Route::get('/akunAll',[AkunController::class, 'all']);
    Route::get('/akunNew/{id}',[AkunController::class, 'new']);

    Route::prefix('/jurnal')->controller(JurnalController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/','store');
        Route::put('/{id}','update');
        Route::delete('/{id}', 'destroy');
    });

    Route::get('/jurnalMaster',[JurnalController::class, 'master']);
    Route::get('/jurnalLookUpAkun',[JurnalController::class, 'lookupAkun']);
});

Route::prefix('/test')->controller(TestController::class)->group(function () {
    // Route::get('/add', 'add');

    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::post('/','store');
    Route::put('/{id}','update');
    Route::delete('/{id}', 'destroy');
});
