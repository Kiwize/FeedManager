<?php

use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\FeedsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('events', "App\Http\Controllers\ArticlesController@index");
Route::post('events/search', "App\Http\Controllers\ArticlesController@store");
