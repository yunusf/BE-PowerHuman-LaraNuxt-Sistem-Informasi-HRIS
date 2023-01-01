<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CompanyController;
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

// Company
Route::get('company', [CompanyController::class, 'all']); // memanggil controller companies api
Route::post('company', [CompanyController::class, 'create'])->middleware('auth:sanctum');

// AUTH|USER
Route::post('login', [AuthController::class, 'login']); // kirim data => membuat token
Route::post('register', [AuthController::class, 'register']); // kirim data => membuat token
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum'); // kirim data => hapus token
Route::get('user', [AuthController::class, 'fetch'])->middleware('auth:sanctum'); // get user data using token login/regis
