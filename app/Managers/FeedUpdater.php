<?php

namespace App\Managers;

use App\Models\Feed;
use App\Models\Article;

class FeedUpdater
{
    public static function update()
    {
        $addedArticles = 0;
        $modifiedArticles = 0;
        $unchangedArticles = 0;
        $articlesBeforeUpdate = Article::count();

        $hashManager = new HashManager;
        $allFeedsLinks = Feed::select(['link', 'id', 'articlesQuantity'])->get();

        $startTime = microtime(true);

        foreach ($allFeedsLinks as $feed) {
            $rssData = new RSSData($feed->link);
            for ($i = 0; $i < $rssData->getArticleCount(); $i++) {
                $rssArticle = $rssData
                    ->getArticle($i);

                $feedHashedArticle = $hashManager
                    ->hashArticle(
                        $rssArticle
                    );

                /** @var \App\Models\Article|null $article */
                $article = Article::where('staticHash', '=', $feedHashedArticle['staticHash'])->first();

                // no article found: create it
                if (true === is_null($article)) {
                    FeedUpdater::addArticle(
                        $rssData,
                        $i,
                        $feed->id
                    );

                    $addedArticles++;
                    $feed->fill(['articleQuantity' => ($feed->articleQuantity + 1)]);
                    continue;
                }

                // compare rss article and model article modified attributes values
                // depending of their dynamic hashe
                if ($article->dynamicHash === $feedHashedArticle['dynamicHash']) {
                    $unchangedArticles++;

                    continue;
                }

                // update article
                $article
                    ->fill([
                        'link' => $rssArticle->link,
                        'title' => $rssArticle->title,
                        'description' => $rssArticle->description,
                    ])
                    ->save();

                $modifiedArticles++;
            }
        }

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

    private static function addArticle(RSSData $rssData, int $id, int $feedID)
    {
        $newArticle = new Article;
        $newArticle->title = $rssData->getTitle($id);
        $newArticle->description = $rssData->getDescription($id);
        $newArticle->link = $rssData->getLink($id);
        $newArticle->guid = $rssData->getGUID($id);
        $newArticle->staticHash = (string)(substr(md5((strtotime($rssData->getPubdate($id)) . substr(md5($rssData->getGUID($id)), 0, 6))), 0, 8));
        $newArticle->dynamicHash = (string)(substr(md5($rssData->getTitle($id)), 0, 6) . substr(md5($rssData->getDescription($id)), 0, 6) . substr(md5($rssData->getLink($id)), 0, 6));
        $newArticle->pubdate = $rssData->getPubdate($id);
        $newArticle->pubdateTimestamp = strtotime($rssData->getPubdate($id));
        $newArticle->feed_id = $feedID;
        $newArticle->save();
    }
}
