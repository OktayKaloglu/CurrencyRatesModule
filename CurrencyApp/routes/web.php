<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DatabaseFiller;

use App\Http\Controllers\AdapterController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\AccountsAPIController;
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

Route::get('/settings/account',AccountsController::class.'@edit')->middleware('auth')->name('settings/account');
Route::patch('/settings/account',AccountsController::class.'@update');





Route::get('/main',DatabaseFiller::class.'@mainpage');

Route::get('/test',AdapterController::class.'@adapterTCMB');



Route::post('/parityfill',DatabaseFiller::class.'@fillparity');
Route::get('/showparity',DatabaseFiller::class.'@viewparity')->middleware('auth')->name('showparity');

Route::post('/ratesfill',DatabaseFiller::class.'@ratesfill');
Route::get('/showrates',DatabaseFiller::class.'@viewrates')->middleware('auth')->name('showrates');


Route::get('/settings/apis',AccountsAPIController::class.'@view')->middleware('auth')->name('settings/apis');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
