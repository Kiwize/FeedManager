<?php

namespace App\Http\Controllers;

use App\Managers\ArticleManager;
use App\Managers\FeedManager;
use App\Managers\RSSData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class FeedsController extends Controller
{
    /**
     * getFeedList
     *
     * @return JsonResponse
     */
    public function getFeedList(): JsonResponse {
        return response()->json(array('result' => FeedManager::paginate()), 200);
    }

    public function deleteFeed(Request $request) {
        FeedManager::delete($request->feedID);
    }

    /**
     * addFeed
     *
     * @param  mixed $request
     * @return Redirector
     */
    public function addFeed(Request $request) {
        $request->validate([
            'name' => 'required|max:20',
            'link' => 'required|url',
        ]);

        if (!FeedManager::exists($request->link)) {
            $rssData = new RSSData($request->link);
            $newFeed = FeedManager::create($request->name, $request->link);
            //Add all article from the current feed.
            ArticleManager::createAllArticles($rssData, $newFeed->id);
        }

        return redirect('/manager');
    }
}
