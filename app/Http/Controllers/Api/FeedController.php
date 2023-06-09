<?php

namespace App\Http\Controllers\Api;

use App\Config\Config;
use App\Http\Controllers\Controller;
use App\Managers\ArticleManager;
use App\Managers\FeedManager;
use App\Managers\RSSData;

use App\Models\Article;
use App\Models\Feed;
use App\Validations;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FeedController extends Controller
{
    /**
     * getFeedList
     *
     * @return JsonResponse
     * @method GET /api/feeds
     * @method POST /api/feeds(array ids)
     */
    public function fetch(Request $request): JsonResponse
    {
        switch ($request->getMethod()) {
            case "POST":
                $validator = Validations::feedIDFetchValidation($request);
                if ($validator->getStatusCode() != Response::HTTP_OK) {
                    return $validator;
                }

                $ids = $request->feed_id_array;
                $feeds = FeedManager::getFormIDArray($ids);
                return response()->json($feeds);

            default:
                return response()->json(array('result' => Feed::paginate(Feed::count())));
        }
    }

    /**
     * deleteFeed
     *
     * @param  Request $request
     * @return JsonResponse
     * @method DELETE /api/feeds int feedID
     */
    public function delete(Request $request): JsonResponse
    {
        $validator = Validations::feedDeleteIDValidation($request);
        if ($validator->getStatusCode() !== Response::HTTP_OK) {
            return $validator;
        }

        $feed = Feed::where('id', '=', $request->feedID)->first();
        if (is_null($feed)) {
            return response()->json(['error' => 'feed_not_found'], Response::HTTP_NOT_FOUND);
        } else {
            $feed->delete();
            return response()->json(['deleted_feed' => $feed], Response::HTTP_NO_CONTENT);
        }
    }

    /**
     * addFeed
     *
     * @param  Request $request
     * @return Redirector
     * @method PUT /api/feeds string name, url link
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validations::feedStoreValidation($request);
        if ($validator->getStatusCode() !== Response::HTTP_OK) {
            return $validator;
        }

        if (!FeedManager::exists($request->link)) {
            $rssData = new RSSData($request->link);
            $newFeed = FeedManager::create($request->name, $request->link);
            if (ArticleManager::createAllArticles($rssData, $newFeed->id) == false) {
                return response()->json(['error' => 'Internal server error'], Response::HTTP_INTERNAL_SERVER_ERROR);
            } else {
                $addedArticles = Article::where('feed_id', '=', $newFeed->id)->count();
            }

            return response()->json(['created_feed' => $newFeed, 'added_articles' => $addedArticles], Response::HTTP_CREATED);
        } else {
            return response()->json(['error' => $request->link . ' is already registred.'], Response::HTTP_BAD_REQUEST);
        }
    }
}
