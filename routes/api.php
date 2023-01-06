<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\TeamController;
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

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

// Company API
Route::prefix('company')->middleware('auth:sanctum')->name('company.')->group(function () {
    Route::get('', [CompanyController::class, 'fetch'])->name('fetch'); // memanggil controller companies api
    Route::post('', [CompanyController::class, 'create'])->name('create'); // api.com/company
    Route::post('update/{id}', [CompanyController::class, 'update'])->name('update'); // api.com/company
});

// AUTH|USER
Route::post('login', [AuthController::class, 'login']); // kirim data => membuat token
Route::post('register', [AuthController::class, 'register']); // kirim data => membuat token
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum'); // kirim data => hapus token
Route::get('user', [AuthController::class, 'fetch'])->middleware('auth:sanctum'); // get user data using token login/regis

// TEAM
Route::prefix('team')->middleware('auth:sanctum')->name('team')->group(function () {
    Route::get('', [TeamController::class, 'fetch'])->name('fetch');
    Route::post('', [TeamController::class, 'create'])->name('create');
    Route::post('update/{id}', [TeamController::class, 'update'])->name('update');
    Route::delete('{id}', [TeamController::class, 'destroy'])->name('delete');
});

// Role
Route::prefix('role')->middleware('auth:sanctum')->name('role')->group(function () {
    Route::get('', [RoleController::class, 'fetch'])->name('fetch');
    Route::post('', [RoleController::class, 'create'])->name('create');
    Route::post('update/{id}', [RoleController::class, 'update'])->name('update');
    Route::delete('{id}', [RoleController::class, 'destroy'])->name('delete');
});
