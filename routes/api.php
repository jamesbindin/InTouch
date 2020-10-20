<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserApiController;
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

Route::group(['middleware' => ['CheckApiKey']], function(){
    // GET: /api/user
    Route::get('user', [UserApiController::class, 'get']);
    // GET: /api/user/{Username}
    Route::get('user/{Username}', [UserApiController::class, 'get']);
    // POST: /api/user
    Route::post('user', [UserApiController::class, 'post']);
    // PUT: /api/user
    Route::put('user', [UserApiController::class, 'put']);
    // DELETE: /api/user
    Route::delete('user/{Username}', [UserApiController::class, 'delete']);
});