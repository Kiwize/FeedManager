<?php

namespace App\Managers;

use App\Models\Feed;
use App\Models\Article;
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

        $hashManager = new HashManager;
        $allFeedsLinks = Feed::select(['link', 'id'])->get();

        $startTime = microtime(true);

        foreach ($allFeedsLinks as $feed) {
            $rssData = new RSSData($feed->link);

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
                    ArticleManager::createArticle(
                        $rssData,
                        $i,
                        $feed->id
                    );

                    $addedArticles++;
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
                            ])
                            ->save();
                        break;

                    case "json":
                        try {
                            $article
                                ->fill([
                                    'link' => $rssArticle->url,
                                    'title' => $rssArticle->title,
                                    'description' => mb_substr($rssArticle->content_html, 0, 250, "utf-8"),
                                ])
                                ->save();
                        } catch (ErrorException $ex) {
                            $article
                                ->fill([
                                    'link' => $rssArticle->url,
                                    'title' => "Missing title",
                                    'description' => mb_substr($rssArticle->content_html, 0, 250, "utf-8"),
                                ])
                                ->save();
                        }
                        break;
                    default:
                        die;
                }

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
}