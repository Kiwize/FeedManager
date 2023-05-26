<?php

namespace App\Managers;
use App\Models\Feed;

class FeedManager {

    public static function delete(int $id) {
        Feed::where('id', '=', $id)->delete();
    }

    public static function create(string $name, string $link):Feed {
        $feed = new Feed;
        $feed->name = $name;
        $feed->link = $link;
        $feed->save();

        return $feed;
    }

    public static function exists(string $link):bool {
        return Feed::where('link', '=', $link)->count() > 0;
    }
    
    public static function getAllIDs():array {
        $ids = array();
        $feedsID = Feed::select('id')->get();

        foreach ($feedsID as $feedID) {
            array_push($ids, $feedID);
        }

        return $ids;
    }

    public static function getFromLink(string $link): Feed {
        return Feed::where('link', '=', $link)->first();
    }
}