<?php

namespace App\Http\Controllers;

use App\Managers\ArticleManager;
use App\Managers\RSSData;
use App\Models\Feed;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Managers\FeedUpdater;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ArticlesController extends Controller
{    
    /**
     * index
     *
     * @return JsonResponse
     */
    public function index() {
        $articles = DB::table('articles')->paginate(2);
        return response()->json($articles);
    }
    
    /**
     * Recherche des articles par titre, description, date de publication
     * 
     * @param  Request $request
     * @return JsonResponse
     */
    public function store(Request $request) {
        $articles = Article::
        where('title', 'LIKE', '%' . $request->titleFilter . "%")
        ->where('description', 'like', '%' . $request->descriptionFilter . "%")
        ->orderBy('title')
        ->whereBetween('pubdate_timestamp', [strtotime($request->from), strtotime($request->to)])
        ->cursorPaginate($request->articlesPerPage);

        return response()->json($articles);
    }

    /**
     * getArticleList
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getArticleList(Request $request): JsonResponse {
        $filteredArticles = ArticleManager::sortArticles($request->search);
        return response()->json(array('result' => $filteredArticles, 'articleCount' => Article::count(), 'feedCount' => Feed::count()), 200);
    }

    public static function addArticle(RSSData $rssData, int $id, int $feedID)
    {
        $newArticle = new Article;
        $newArticle->title = $rssData->getTitle($id);
        $newArticle->description = $rssData->getDescription($id);
        $newArticle->link = $rssData->getLink($id);
        $newArticle->guid = $rssData->getGUID($id);
        $newArticle->static_hash = (string)(substr(md5((strtotime($rssData->getPubdate($id)) . substr(md5($rssData->getGUID($id)), 0, 6))), 0, 8));
        $newArticle->dynamic_hash = (string)(substr(md5($rssData->getTitle($id)), 0, 6) . substr(md5($rssData->getDescription($id)), 0, 6) . substr(md5($rssData->getLink($id)), 0, 6));
        $newArticle->pubdate = $rssData->getPubdate($id);
        $newArticle->pubdate_timestamp = strtotime($rssData->getPubdate($id));
        $newArticle->feed_id = $feedID;
        $newArticle->save();
    }
}
