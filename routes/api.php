<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// GET: /api/user
Route::get('user', [UserController::class, 'get']);
// GET: /api/user/{Username}
Route::get('user/{Username}', [UserController::class, 'get']);
// POST: /api/user
Route::post('user', [UserController::class, 'post']);
// PUT: /api/user
Route::put('user', [UserController::class, 'put']);
// DELETE: /api/user
Route::delete('user/{Username}', [UserController::class, 'delete']);
