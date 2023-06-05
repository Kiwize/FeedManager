<?php

namespace App\Http\Controllers;

use App\Config\Config;
use App\Managers\ArticleManager;
use App\Managers\RSSData;
use App\Models\Feed;
use App\Models\Article;
use App\Validations;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Managers\FeedUpdater;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ArticlesController extends Controller
{
    /**
     * getLocale
     * Renvoie tous les articles correspondant à la langue souhaitée, paginés. 
     * @param  Request $request
     * @return JsonResponse
     */
    public function getLocale(Request $request): JsonResponse
    {
        if (Validations::validateGetLocale($request)) {
            return response()->json(['error' => 'Validation error'], 400);
        }

        if (is_null($request->articlesPerPage))
            $articlesPerPage = Config::ARTICLES_PER_PAGES;
        else
            $articlesPerPage = $request->articlesPerPage;

        $articles = tap(Article::where('locale', "=", $request->locale)->paginate($articlesPerPage), function ($paginatedInstance) {
            return $paginatedInstance->getCollection()->transform(function ($value) {
                $value = ArticleManager::toJson($value);
                return $value;
            });
        });

        return response()->json($articles);
    }

    /**
     * index
     * Renvoie tous les articles paginés
     * @param  Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        if (Validations::validateIndex($request)) {
            return response()->json(['error' => 'Validation error'], 400);
        }

        if (is_null($request->articlesPerPage))
            $articlesPerPage = Config::ARTICLES_PER_PAGES;
        else
            $articlesPerPage = $request->articlesPerPage;

        $articles = tap(DB::table('articles')->paginate($articlesPerPage), function ($paginatedInstance) {
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
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        if (Validations::validateStore($request)) {
            return response()->json(['error' => 'Validation error'], 400);
        }

        $articles = tap(Article::where('title', 'LIKE', '%' . $request->titleFilter . "%")
            ->where('description', 'like', '%' . $request->descriptionFilter . "%")
            ->whereBetween('pubdate', [$request->from, $request->to])
            ->paginate($request->articlesPerPage), function ($paginatedInstance) {
            return $paginatedInstance->getCollection()->transform(function ($value) {
                $value = ArticleManager::toJson($value);
                return $value;
            });
        });

        return response()->json($articles, 200);
    }

    /**
     * getArticleList
     * Renvoie le nombre d'articles et de flux enregistrés.
     * @param Request $request
     * @return JsonResponse
     */
    public function getArticleList(Request $request): JsonResponse
    {
        if (Validations::validateGetArticleList($request)) {
            return response()->json(['error' => 'Validation error'], 400);
        }

        $filteredArticles = ArticleManager::sortArticles($request->search);
        return response()->json(array('result' => $filteredArticles, 'articleCount' => Article::count(), 'feedCount' => Feed::count()), 200);
    }

    /**
     * refresh
     * Rafraichit les articles, ajoute les nouveau et met à jour le contenu des articles existants
     * @return void
     */
    public function refresh(): void
    {
        FeedUpdater::update();
    }
}
