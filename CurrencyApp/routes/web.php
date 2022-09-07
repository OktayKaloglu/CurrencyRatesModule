<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DatabaseFiller;

use App\Http\Controllers\AdapterController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\AccountsAPIController;
use App\Http\Controllers\Auth\UserAuthController;
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


Route::apiResource('/employee', 'EmployeeController')->middleware('auth:api');


Route::GET('/settings/account',UserAuthController::class.'@edit')->middleware('auth')->name('settings/account');
Route::patch('/settings/account',UserAuthController::class.'@update');

Route::POST('/settings/preferences',AccountsController::class.'@editPreferences')->middleware('auth')->name('settings/preferences');

Route::POST('/settings/apis',AccountsAPIController::class.'@view')->middleware('auth')->name('settings/apis');


Route::get('/test',DatabaseFiller::class.'@test');




Route::get('/showparity',DatabaseFiller::class.'@viewparity')->middleware('auth')->name('showparity');


Route::get('/showrates',DatabaseFiller::class.'@viewrates')->middleware('auth')->name('showrates');

Route::get('/showvendors',DatabaseFiller::class.'@viewvendors')->middleware('auth')->name('showvendors');



Auth::routes(


);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
