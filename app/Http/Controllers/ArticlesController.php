<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Managers\FeedUpdater;
use App\Managers\HashManager;

class ArticlesController extends Controller
{
    public function getArticleList(Request $request)
    {
        switch ($request->searchFilter) {
            case "newest":
                $articles = Article::orderBy('pubdateTimestamp', 'DESC')->where('title', 'LIKE', '%' . $request->search . '%')->get();
                return response()->json(array('result' => $this->concatSearchresults($articles), 'articleCount' => Article::count(), 'feedCount' => Feed::count()), 200);
                break;

            case "oldest":
                $articles = Article::orderBy('pubdateTimestamp', 'ASC')->where('title', 'LIKE', '%' . $request->search . '%')->get();
                return response()->json(array('result' => $this->concatSearchresults($articles), 'articleCount' => Article::count(), 'feedCount' => Feed::count()), 200);
                break;

            case "alphabetTitle":
                $articles = Article::orderBy('title')->where('title', 'LIKE', '%' . $request->search . '%')->get();
                return response()->json(array('result' => $this->concatSearchresults($articles), 'articleCount' => Article::count(), 'feedCount' => Feed::count()), 200);
                break;
        }
    }

    protected function concatSearchresults(Object $articles): array
    {
        $pages = [];
        $pageContent = null;

        $articleCounter = 0;
        $pageCounter = 0;

        foreach ($articles as $article) {
            if ($articleCounter === 0) {
                $pageCounter++;
            }
            $pageContent .= '<div class="article"><a href="' . $article->link . '" target="_blank>';
            $pageContent .= '<p class="title">' . $article->title . "</p>";
            $pageContent .= '<p class="description">' . $article->description . '</p>';
            $pageContent .= '<p class="pubdate">Publié le ' . $article->pubdate . ' par <span>' . Feed::select('name')->where('id', '=', $article->feed_id)->get()[0]->name . '</span></p>';
            $pageContent .= '</a></div>';
            $articleCounter++;
            if ($articleCounter === 20) {
                $articleCounter = 0;
                array_push($pages, $pageContent);
                $pageContent = null;
            }
        }
        array_push($pages, $pageContent);
        return $pages;
    }

    public function refresh()
    {
        FeedUpdater::update();
    }
}
