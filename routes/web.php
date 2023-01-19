<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LogsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TradeController;

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
    return view('home',['title' =>'Home']);
})->name('home');

//register
Route::get('register',[UserController::class,'register'])->name('register');
Route::POST('register',[UserController::class,'register_action'])->name('register.action');

//login
Route::get('login',[UserController::class,'login'])->name('login');
Route::POST('login',[UserController::class,'login_action'])->name('login.action');

//logout
Route::get('logout',[UserController::class,'logout'])->name('logout');

//password change
Route::get('password',[UserController::class,'password'])->name('password');
Route::POST('password',[UserController::class,'password_action'])->name('password.action');

//deposit
Route::get('deposit',[UserController::class,'deposit'])->name('deposit');
Route::POST('deposit',[UserController::class,'deposit_action'])->name('deposit.action');


//transfer 
Route::get('transfer',[UserController::class,'transfer'])->name('transfer');
Route::POST('transfer',[UserController::class,'transfer_action'])->name('transfer.action');


// buy-sell
Route::get('trade',[TradeController::class,'trade'])->name('trade');
Route::POST('trade',[TradeController::class,'trade_action'])->name('trade.action');
Route::get('confirm/{order}',[TradeController::class,'confirm'])->name('trade.confirm');
Route::PUT('confirm_action}',[TradeController::class,'confirm_action'])->name('trade.confirmaction');


Route::get('logActivity', [LogsController::class,'logActivity']);
