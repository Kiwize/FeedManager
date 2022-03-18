<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Managers\FeedUpdater;

class ArticlesController extends Controller
{
    public function getArticleList(Request $request)
    {
        $article = Article::where('title', 'LIKE', '%' . $request->search . '%');

        switch ($request->searchFilter) {
            case "newest":
                $articles = $article->orderBy('pubdateTimestamp', 'DESC')->get();
                return response()->json(array('result' => $this->concatSearchresults($articles), 'articleCount' => Article::count(), 'feedCount' => Feed::count()), 200);

            case "oldest":
                $articles = $article->orderBy('pubdateTimestamp', 'ASC')->get();
                return response()->json(array('result' => $this->concatSearchresults($articles), 'articleCount' => Article::count(), 'feedCount' => Feed::count()), 200);

            case "alphabetTitle":
                $articles = $article->orderBy('title')->get();
                return response()->json(array('result' => $this->concatSearchresults($articles), 'articleCount' => Article::count(), 'feedCount' => Feed::count()), 200);
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
