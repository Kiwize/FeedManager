<?php

use App\Managers\FeedUpdater;
use Illuminate\Support\Facades\Route;

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

Route::get("/manager", function() {
    return view('manager');
});

Route::get("/add", function() {
    return view('add');
});

Route::get("/search", function() {
    return view("/search");
});