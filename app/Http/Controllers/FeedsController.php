<?php

namespace App\Http\Controllers;

use App\Config\Config;
use App\Managers\ArticleManager;
use App\Managers\FeedManager;
use App\Managers\RSSData;

use App\Models\Feed;
use App\Validations;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FeedsController extends Controller
{
    /**
     * getFeedList
     *
     * @return JsonResponse
     */
    public function getFeedList(): JsonResponse {
        return response()->json(array('result' => Feed::paginate(Config::FEEDS_PER_PAGES)), 200);
    }
    
    /**
     * deleteFeed
     *
     * @param  mixed $request
     * @return void
     */
    public function deleteFeed(Request $request) {
        if(Validations::validateDeleteFeed($request) === true)
            return response()->json(['error' => 'Validation error'], 400);

        if(FeedManager::delete($request->feedID) === false) {
            return response()->json(['error' => "Feed doesn't exist"], 400);
        }
    }

    /**
     * addFeed
     *
     * @param  mixed $request
     * @return Redirector
     */
    public function addFeed(Request $request) {
        if(Validations::validateAddFeed($request) === true)
            return response()->json(['error' => 'Validation error'], 400);

        if (!FeedManager::exists($request->link)) {
            $rssData = new RSSData($request->link);
            $newFeed = FeedManager::create($request->name, $request->link);
            ArticleManager::createAllArticles($rssData, $newFeed->id);
        } else {
            return response()->json(['error' => 'Feed' . $request->link . 'already registred.'], 400);
        }

        return redirect('/manager', 201);
    }
}
