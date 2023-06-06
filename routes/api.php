<?php

use App\Http\Controllers\api\APIArticlesController;
use App\Http\Controllers\api\APIFeedsController;
use App\Managers\FeedUpdater;
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

Route::get('articles', [APIArticlesController::class, "fetch"]);
Route::get('articles/locales', [APIArticlesController::class, "listAvailableLocales"]);
Route::get("articles/refresh", [APIArticlesController::class, 'refresh']);
Route::post('articles/search', [APIArticlesController::class, 'fetch']);

### Feed related routes ###

Route::get("feeds", [APIFeedsController::class, 'fetch']);
Route::put('feeds/create', [APIFeedsController::class, 'store']);
Route::delete("feeds/delete", [APIFeedsController::class, 'delete']);


