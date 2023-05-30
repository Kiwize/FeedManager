<?php

namespace App\Http\Controllers;

use App\Managers\ArticleManager;
use App\Managers\RSSData;
use App\Models\Feed;
use App\Models\Article;
use DateTime;
use Illuminate\Http\Request;
use App\Managers\FeedUpdater;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ArticlesController extends Controller
{    
    /**
     * index
     *
     * @return JsonResponse
     */
    public function index(Request $request) {
        if(is_null($request->articlePerPage)) $articlePerPage = 6; else $articlePerPage = $request->articlePerPage;
        $articles = tap(DB::table('articles')->paginate($articlePerPage), function($paginatedInstance) {
            return $paginatedInstance->getCollection()->transform(function ($value) {
                $value = ArticleManager::toJson($value);
                return $value;
            });
        });

        return response()->json($articles);
    }
    
    /**
     * Recherche des articles par titre, description, date de publication
     * 
     * @param  Request $request
     * @return JsonResponse
     */ 

     
    public function store(Request $request) {
        $articles = tap(Article::
        where('title', 'LIKE', '%' . $request->titleFilter . "%")
        ->where('description', 'like', '%' . $request->descriptionFilter . "%")
        ->whereBetween('pubdate', [$request->from, $request->to])
        ->paginate($request->articlesPerPage), function($paginatedInstance) {
            return $paginatedInstance->getCollection()->transform(function ($value) {
                $value = ArticleManager::toJson($value);
                return $value;
            });
        });

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

    public function refresh() {
        FeedUpdater::update();
    }
}
