<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientAPI;
use App\Http\Controllers\AccountsAPIController;

use App\Http\Controllers\Queries;

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
Route::get('/rates', [Queries::class,'apiRates']);

Route::get('/api/register', [AccountsAPIController::class, 'registerAction']);
Route::get('/api/login', [AccountsAPIController::class, 'userInfoAction']);

Route::middleware('auth:api')->group(function () {

    Route::get('get-user', [AccountsAPIController::class, 'userInfoAction']);


});
