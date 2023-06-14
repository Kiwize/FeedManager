<?php

namespace App\Managers;

use App\Models\Article;
use App\Models\Feed;
use ErrorException;

class FeedManager
{

    public static function delete(int $id): bool
    {
        return Feed::where('id', '=', $id)->delete();
    }

    /**
     * create
     * Creates a new feed in database,
     * @param  mixed $name
     * @param  mixed $link
     * @return Feed Created feed
     * @return null If the feed already exists
     */
    public static function create(string $name, string $link, ?string $author_logo): ?Feed
    {
        if (FeedManager::exists($link))
            return null;

        $feed = new Feed;
        $feed->name = $name;
        $feed->link = $link;
        $feed->author_logo = $author_logo;
        $feed->save();

        return $feed;
    }
    
    /**
     * storeFeedAndAddArticles
     * Ajoute les flux et tous les articles associés.
     * @param  mixed $name
     * @param  mixed $link
     * @return bool False si l'ajout échoue
     * @return array Contenant le flux ajouté, le nombre d'articles et la langue du flux ajouté si l'ajout est réussis.
     */
    public static function storeFeedAndAddArticles(string $name, string $link, ?string $author_logo): bool|array
    {
        try {
            $rssData = new RSSData($link);
            $newFeed = FeedManager::create($name, $link, $author_logo);
        } catch (ErrorException $ex) {
            return false;
        }

        if (ArticleManager::createAllArticles($rssData, $newFeed->id) == false || is_null($newFeed)) {
            return false;
        } else {
            $addedArticlesCount = Article::where('feed_id', '=', $newFeed->id)->count();
        }

        $addedArticlesLocale = Article::where('feed_id', '=', $newFeed->id)->select('locale')->get()->first();
        $newFeed->locale = is_null($addedArticlesLocale) ? "" : $addedArticlesLocale->locale;
        $newFeed->save();

        return ['created_feed' => $newFeed, 'added_articles' => $addedArticlesCount, 'feed_locale' => $addedArticlesLocale];
    }

    public static function exists(string $link): bool
    {
        return Feed::where('link', '=', $link)->count() > 0;
    }

    public static function getAllIDs(): array
    {
        $ids = array();
        $feedsID = Feed::select('id')->get();

        foreach ($feedsID as $feedID) {
            array_push($ids, $feedID);
        }

        return $ids;
    }

    public static function getFromLink(string $link): Feed
    {
        return Feed::where('link', '=', $link)->first();
    }

    public static function getFromID(int $id): Feed
    {
        return Feed::where('id', '=', $id)->first();
    }

    public static function getLocale(string $localeFilter)
    {
        return Feed::where('locale', '=', $localeFilter)->get();
    }

    public static function getFormIDArray(array $ids): array
    {
        $feeds = array();
        foreach ($ids as $id) {
            array_push($feeds, FeedManager::getFromID($id));
        }

        return $feeds;
    }
}
