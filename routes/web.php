<?php

use App\Config\Config;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\Web\ArticleController;
use App\Http\Controllers\Web\SearchController;
use App\Managers\FeedUpdater;
use App\Models\Feed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

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

Route::get('/', [ArticleController::class, 'fetchLatest'])->name("articles.fetch");

Route::get("/manager", [SearchController::class, 'search'])->name("feeds.search");

Route::get("/add", function () {
    return view('add');
});


