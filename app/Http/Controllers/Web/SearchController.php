<?php

namespace App\Http\Controllers\Web;

use App\Config\Config;
use App\Http\Controllers\Controller;
use App\Models\Feed;
use App\Validations;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class SearchController extends Controller
{    
    /**
     * search
     * Search by name and locale among the feeds
     * @param  mixed $request
     * @return void
     * @method GET search(string nameFilter, string localeFilter)
     */
    public function search(Request $request): View|JsonResponse {
        $validator = Validations::feedSearchValidation($request);
        if ($validator->getStatusCode() !== Response::HTTP_OK) {
            return $validator;
        }

        $feeds = Feed::where('name', 'like', '%' . $request->nameFilter . '%')->where('locale', 'like', '%' . $request->localeFilter . '%')->paginate(Config::RESULTS_PER_PAGES);
        $locales = Feed::select('locale')->where('locale', '!=', "")->distinct()->get();
    
        return view('feedmanager', compact('locales', 'feeds'));
    }
}
