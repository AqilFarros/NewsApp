<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\NewsController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\FrontEndController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// untuk mengakses harus dalam posisi login
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/updatePassword', [AuthController::class, 'updatePassword']);
    Route::post('/createProfile', [AuthController::class, 'storeProfile']);
    Route::post('/updateProfile', [AuthController::class, 'updateProfile']);
});

// Route For Admin
Route::group(['middleware' => ['auth:sanctum', 'admin']], function () {
    // Route Category
    Route::post('/category/create', [CategoryController::class, 'store']);
    Route::post('/category/update/{id}', [CategoryController::class, 'update']);
    Route::delete('/category/destroy/{id}', [CategoryController::class, 'destroy']);

    // Route News
    Route::post('/news/create', [NewsController::class, 'store']);
    Route::post('/news/update/{id}', [NewsController::class, 'update']);
    Route::delete('/news/destroy/{id}',[NewsController::class, 'destroy']);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/allUsers', [AuthController::class, 'allUsers']);
Route::get('/allNews', [NewsController::class, 'index']);
Route::get('/news/{id}', [NewsController::class, 'show']);
Route::get('/allCategory', [CategoryController::class, 'index']);
Route::get('/category/{id}', [CategoryController::class, 'show']);
Route::get('/carousel', [FrontEndController::class, 'index']);
