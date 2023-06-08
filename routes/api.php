<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\FeedController;
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

### Article related routes ###

Route::get('articles', [ArticleController::class, "fetch"]);
Route::get('articles/locales', [ArticleController::class, "listAvailableLocales"]);
Route::get("articles/refresh", [ArticleController::class, 'refresh']);
Route::post('articles/search', [ArticleController::class, 'fetch']);

### Feed related routes ###

Route::get("feeds", [FeedController::class, 'fetch']);
Route::post('feeds/create', [FeedController::class, 'store']);
Route::delete("feeds/delete", [FeedController::class, 'delete']);
