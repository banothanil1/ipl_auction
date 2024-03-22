<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auction_controller;
use PharIo\Manifest\AuthorCollection;

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


Route::post('addplayer',[auction_controller::class,'addplayer']);
Route::post('addbuyer',[auction_controller::class,'addbuyer']);
Route::get('buyerlogin',[auction_controller::class,'buyerlogin']);

Route::get('buyerlogout',[auction_controller::class,'logout']);
Route::get('playerbiding',[auction_controller::class,'biding']);