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
        $allFeedsLinks = Feed::select(['link', 'id'])->get();

        $startTime = microtime(true);

        foreach ($allFeedsLinks as $feed) {
            $rssData = new RSSData($feed->link);
            for ($i = 0; $i < $rssData->getArticleQuantity(); $i++) {
                $rssArticle = $rssData
                    ->getArticle($i);

                $feedHashedArticle = $hashManager
                    ->hashArticle(
                        $rssArticle
                    );

                /** @var \App\Models\Article|null $article */
                $article = Article::where(
                    'staticHash',
                    '=',
                    $feedHashedArticle['staticHash']
                )->first();

                // no article found: create it
                if (true === is_null($article)) {
                    FeedUpdater::addArticle(
                        $rssData,
                        $i,
                        $feed->id
                    );

                    $addedArticles++;

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

                /*
                if(Article::where('staticHash', '=', $hashManager->hashArticle($rssData->getArticle($i))['staticHash'])->count() == 0) {
                    //Create new record in database.
                    FeedUpdater::addArticle($rssData, $i, $feed->id);
                } else {
                    //Do multiple tests to see what changed in the article.
                    if (Article::where('dynamicHash', '=', $hashManager->hashArticle($rssData->getArticle($i))['dynamicHash'])->count() == 0) {
                        //Article has been changed. (title, description or link)
                        Article::where('staticHash', '=', $hashManager->hashArticle($rssData->getArticle($i))['staticHash'])->delete();
                        FeedUpdater::addArticle($rssData, $i, $feed->id);
                        $modifiedArticles++;
                    } else {
                        $unchangedArticles++;
                    }
                }
                */
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

    public static function addArticle(RSSData $rssData, int $id, int $feedID)
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
