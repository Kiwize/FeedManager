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
use ErrorException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class FeedController extends Controller
{
    /**
     * getFeedList
     *
     * @return JsonResponse
     * @method GET /api/feeds
     * @method POST /api/feeds(string title_filter)
     */
    public function fetch(Request $request): JsonResponse|View
    {
        switch ($request->getMethod()) {
            case "POST":
                $validator = Validations::feedFetchSearchValidation($request);
                if ($validator->getStatusCode() != Response::HTTP_OK) {
                    return $validator;
                }

                $feeds = Feed::where('name', 'like', '%' . $request->nameFilter . '%')->where('locale', 'like', '%' . $request->localeFilter . '%')->paginate(Config::RESULTS_PER_PAGES);
                $locales = Feed::select('locale')->where('locale', '!=', "")->distinct()->get();

                return response()->json(['result' => $feeds, 'locales' => $locales]);

            default:
                if (isset($request->locale_filter)) {
                    $feeds = FeedManager::getLocale($request->locale_filter)->paginate(3);
                } else {
                    $feeds = Feed::paginate(Feed::count());
                }

                $accessStatus = array();

                foreach ($feeds as $feed) {
                    try {
                        $rssData = new RSSData($feed->link);
                        $accessStatus[$feed->id] = array('readable' => $rssData !== "unknown", 'articles_found' => ArticleManager::countArticlesFromFeed($feed));
                    } catch (ErrorException $ex) {
                        $accessStatus[$feed->id] = array('readable' => false, 'articles_found' => 0);
                    }
                }

                return response()->json(array('result' => $feeds, 'feed_status' => $accessStatus));
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
        DB::beginTransaction();
        $validator = Validations::feedStoreValidation($request);
        if ($validator->getStatusCode() !== Response::HTTP_OK) {
            return $validator;
        }

        if (!FeedManager::exists($request->link)) {
            $created_content = FeedManager::storeFeedAndAddArticles($request->name, $request->link, $request->author_logo);

            if($created_content === false) {
                DB::rollBack();
                return response()->json(['error' => 'Internal server error'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            DB::commit();
            return response()->json($created_content, Response::HTTP_CREATED);
        } else {
            return response()->json(['error' => $request->link . ' is already registred.'], Response::HTTP_BAD_REQUEST);
        }
    }
}
