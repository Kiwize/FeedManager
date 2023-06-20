<?php

namespace App\Http\Controllers\Web;

use App\Config\Config;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Feed;
use App\Validations;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ArticleController extends Controller
{    
    /**
     * fetchLatest
     * Récupères les articles les plus récents en respectants les critères de recherche par nom et langue.
     * @param  Request $request
     * @return View Compilée avec les résultats de recherche
     * @method GET / string localeFilter, int resultsPerPage
     */
    public function fetchLatest(Request $request): View|JsonResponse
    {
        $validator = Validations::articlesFetchValidation($request);
        if ($validator->getStatusCode() !== Response::HTTP_OK) {
            return $validator;
        }

        $iconFeeds = [];
        $articles = Article::orderBy('pubdate', 'DESC')->where('locale', 'like', "%" . $request->localeFilter . "%")->paginate($request->resultsPerPage);
        foreach(Feed::all('id', 'author_logo') as $feed) {
            $iconFeeds[$feed->id] = $feed->author_logo;
        }

        $locales = Feed::select('locale')->where('locale', '!=', "")->distinct()->get();
        $perPage = [20, 75, 100, 200];

        return view('articlemanager', compact('articles', 'iconFeeds', 'locales', 'perPage'));
    }
}
