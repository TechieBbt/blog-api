<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('home', [PostController::class, 'index']);

Route::post('posts', [PostController::class, 'createPost']);

Route::get('post', [PostController::class, 'allPost']);

Route::put('post/{id}', [PostController::class, 'updatePost']);

Route::delete('post/{id}', [PostController::class, 'deletePost']);

// Route::get('home', [UserController::class, 'index']);

Route::post('User', [UserController::class, 'createUser']);

Route::post('login', [UserController::class, 'login']);


