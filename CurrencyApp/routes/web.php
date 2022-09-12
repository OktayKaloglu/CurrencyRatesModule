<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\AccountsAPIController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Queries;
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
    return view('home');
});




Route::GET('/settings/account',UserAuthController::class.'@edit')->middleware('auth')->name('settings/account');
Route::patch('/settings/account',UserAuthController::class.'@update');



Route::GET('/settings/apis',UserAuthController::class.'@editTokens')->middleware('auth')->name('settings/apis');

Route::POST('/settings/apis/add',UserAuthController::class.'@generateToken')->middleware('auth');

Route::POST('/settings/apis/delete',UserAuthController::class.'@deleteToken')->middleware('auth');


Route::get('/settings/preferences',UserAuthController::class.'@editPreferences')->middleware('auth')->name('settings/preferences');
Route::POST('/settings/preferences/add',UserAuthController::class.'@addPref')->middleware('auth');
Route::POST('/settings/preferences/delete',UserAuthController::class.'@deletePref')->middleware('auth');







Route::get('/showparity',Queries::class.'@viewparity')->middleware('auth')->name('showparity');


Route::get('/showrates',Queries::class.'@viewrates')->middleware('auth')->name('showrates');

Route::POST('/rates/search',Queries::class.'@returnRates')->middleware('auth');




Route::get('/showvendors',Queries::class.'@viewvendors')->middleware('auth')->name('showvendors');



Auth::routes(


);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
