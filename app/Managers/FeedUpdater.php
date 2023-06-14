<?php

namespace App\Managers;

use App\Models\Feed;
use App\Models\Article;
use Carbon\Carbon;
use ErrorException;

class FeedUpdater
{
    /**
     * update
     *
     * @return array
     */
    public static function update(): array
    {
        $addedArticles = 0;
        $modifiedArticles = 0;
        $unchangedArticles = 0;
        $articlesBeforeUpdate = Article::count();
        $articlesBeforeUpdate = 0;

        $addedArticleArray = array();

        $hashManager = new HashManager;
        $allFeedsLinks = Feed::select(['link', 'id'])->get();

        $startTime = microtime(true);

        foreach ($allFeedsLinks as $feed) {
            try {
                $rssData = new RSSData($feed->link);
                var_dump($rssData);
            } catch (ErrorException $ex) {
                echo ($ex);
                continue;
            }

            for ($i = 0; $i < $rssData->getArticleCount(); $i++) {
                $rssArticle = $rssData->getArticle($i);

                $feedHashedArticle = $hashManager
                    ->hashArticle(
                        $rssData,
                        $i
                    );

                /** @var \App\Models\Article|null $article */
                $article = Article::where('static_hash', '=', $feedHashedArticle['static_hash'])->first();
                if (is_null($article) === true) {
                    $article = ArticleManager::getArticle(
                        $rssData,
                        $i,
                        $feed->id
                    );

                    if (is_null($article) === false) {
                        array_push($addedArticleArray, $article->toArray());

                        $addedArticles++;
                    }

                    continue;
                }

                // compare rss article and model article modified attributes values
                // depending of their dynamic hashe
                if (strcmp($article->dynamic_hash, $feedHashedArticle['dynamic_hash']) === 0) {
                    $unchangedArticles++;
                    continue;
                }

                // update article
                switch ($rssData->getType()) {

                    case "xml":
                        $article
                            ->fill([
                                'link' => $rssArticle->link,
                                'title' => $rssArticle->title,
                                'description' => $rssArticle->description,
                            ])->save();
                        break;

                        //JSON Case
                    default:
                        $article
                            ->fill([
                                'link' => $rssArticle->url,
                                'title' => property_exists($article, "title") ?  $rssArticle->title : "missing_title",
                                'description' => mb_substr($rssArticle->content_html, 0, 250, "utf-8"),
                            ])->save();
                        break;
                }
                $modifiedArticles++;
            }
        }

        Article::insert($addedArticleArray);

        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        return array(
            'addedArticles' => $addedArticles,
            'unchangedArticles' => $unchangedArticles,
            'modifiedArticles' => $modifiedArticles,
            'articlesBeforeUpdate' => $articlesBeforeUpdate,
            'articlesFound' => Article::count(),
            'executionTime' => $executionTime
        );
    }
}
