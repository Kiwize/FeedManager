<?php

namespace App\Http\Controllers;

use App\Managers\ArticleManager;
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

    public function refresh()
    {
        FeedUpdater::update();
    }
}
