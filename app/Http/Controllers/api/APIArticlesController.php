<?php

namespace App\Http\Controllers\api;

use App\Config\Config;
use App\Http\Controllers\Controller;
use App\Managers\ArticleManager;
use App\Managers\FeedUpdater;
use App\Models\Article;
use App\Validations;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class APIArticlesController extends Controller
{
    /**
     * Recherche des articles par titre, description, date de publication
     * 
     * @param  Request $request
     * @return JsonResponse
     * @method GET /api/articles int results, int resultsPerPage, int page
     * @method POST /api/articles/search string titleFilter, string descriptionFilter, date from, date to, int resultsPerPage, int page, string locale
     */
    public function fetch(Request $request): JsonResponse
    {
        is_null($request->resultsPerPage) ?  $rpp = Config::RESULTS_PER_PAGES : $rpp = $request->resultsPerPage;

        switch ($request->getMethod()) {
            case "POST":
                $validator = Validations::articlesFetchSearchValidation($request);
                if ($validator->getStatusCode() !== Response::HTTP_OK) {
                    return $validator;
                }

                $articles = tap(Article::where('title', 'LIKE', '%' . $request->titleFilter . "%")
                    ->where('description', 'like', '%' . $request->descriptionFilter . "%")
                    ->where('locale', 'like', '%' . $request->locale . "%")
                    ->whereBetween('pubdate', [$request->from, $request->to])
                    ->paginate($rpp), function ($paginatedInstance) {
                    return $paginatedInstance->getCollection()->transform(function ($value) {
                        $value = ArticleManager::toJson($value);
                        return $value;
                    });
                });

                return response()->json($articles);

            default:
                $validator = Validations::articlesFetchValidation($request);
                if ($validator->getStatusCode() !== Response::HTTP_OK) {
                    return $validator;
                }
                $latestArticles = Article::latest()->limit($request->results)->get();
                $articles = tap($latestArticles->paginate($rpp), function ($paginatedInstance) {
                    return $paginatedInstance->getCollection()->transform(function ($value) {
                        $value = ArticleManager::toJson($value);
                        return $value;
                    });
                });

                return response()->json($articles);
        }
    }
    
    /**
     * listAvailableLocales
     *
     * @return JsonResponse
     * @method GET /api/articles/locales
     */
    public function listAvailableLocales(): JsonResponse {
        $locales = Article::select('locale')->distinct()->get();
        return response()->json($locales);
    }
    
    /**
     * refresh
     *
     * @return JsonResponse
     * @method GET /api/articles/refresh
     */
    public function refresh(): JsonResponse {
        $response = FeedUpdater::update();
        return response()->json(['refresh_status' => $response], Response::HTTP_OK);
    }
}
