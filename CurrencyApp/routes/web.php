<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserInsertController;
use App\Http\Controllers\DatabaseFiller;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/create',UserInsertController::class.'@usercreate');

Route::get('/insert',UserInsertController::class.'@insertform');
Route::post('/create',UserInsertController::class.'@insert');




Route::get('/main',DatabaseFiller::class.'@mainpage');

Route::post('/parityfill',DatabaseFiller::class.'@parityfill');
Route::post('/showparity',DatabaseFiller::class.'@showparity');

Route::post('/ratesfill',DatabaseFiller::class.'@ratesfill');
Route::post('/showrates',DatabaseFiller::class.'@showrates');
