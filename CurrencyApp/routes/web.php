<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserInsertController;
use App\Http\Controllers\DatabaseFiller;
use App\Http\Controllers\UserProfile;
use App\Http\Controllers\AdapterController;
use App\Http\Controllers\AccountsController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/settings/account',AccountsController::class.'@edit');
Route::patch('/settings/account',AccountsController::class.'@update');









Route::get('/main',DatabaseFiller::class.'@mainpage');

Route::get('/test',AdapterController::class.'@adapterTCMB');


Route::get('/user',UserProfile::class.'@showuser');
Route::post('/user/token',UserProfile::class.'@apiToken');
Route::post('/newToken',UserProfile::class.'@updateToken');

Route::post('/parityfill',DatabaseFiller::class.'@fillparity');
Route::post('/showparity',DatabaseFiller::class.'@showparity');

Route::post('/ratesfill',DatabaseFiller::class.'@ratesfill');
Route::post('/showrates',DatabaseFiller::class.'@showrates');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
