<?php

namespace App\Managers;

use App\Models\Feed;

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
    public static function create(string $name, string $link): ?Feed
    {
        if (FeedManager::exists($link))
            return null;

        $feed = new Feed;
        $feed->name = $name;
        $feed->link = $link;
        $feed->save();

        return $feed;
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
}
