<?php

namespace App\Http\Controllers;

use ErrorException;
use App\Models\Feed;
use App\Models\Article;
use App\Managers\RSSData;
use Illuminate\Http\Request;

class FeedsController extends Controller {
    public function getFeedList() {
        $result = null;
        $feedsID = Feed::select('id')->get();

        foreach($feedsID as $feedID) {
            $feed = Feed::where('id', '=', $feedID->id)->get()[0];
            $result .= '<button id="'.$feed->name.'" class="feedlink" onclick="javascript:linkOnClick(\''.$feed->name.'\', \''.$feed->link.'\', \''.$feed->id.'\')">';
            $result .= $feed->name;
            $result .= "</button>";
        }

        return response()->json(array('result' => $result), 200);
    }

    public function deleteFeed(Request $request) {
        Feed::where('id', '=', $request->feedID)->delete();
    }

    public function addFeed(Request $request) {
        $request->validate([
            'name' => 'required|max:20',
            'link' => 'required',
        ]);

        if(Feed::where('link', '=', $request->link)->count() > 0) {
            return redirect("/manager");
        }

        $rssData = new RSSData($request->link);

        $feed = new Feed;
        $feed->name = $request->name;
        $feed->link = $request->link;
        $feed->articlesQuantity = $rssData->getArticleCount();
        $feed->icon_link = $request->ilink;
        $feed->save();
        
        $newFeed = Feed::where('name', '=', $request->name)->get()[0];

        Article::where('feed_id', '=', $newFeed->id)->delete();

        //Add all article from the current feed.
        for($i = 0; $i < $rssData->getArticleCount(); $i++) {
            try {
                $article = new Article;
                $article->title = $rssData->getTitle($i);
                $article->description = $rssData->getDescription($i);
                $article->link = $rssData->getLink($i);
                $article->guid = $rssData->getGUID($i);
                $article->staticHash = (string)(substr(md5((strtotime($rssData->getPubdate($i)).substr(md5($rssData->getGUID($i)), 0, 6))), 0, 8));
                $article->dynamicHash = (string)(substr(md5($rssData->getTitle($i)), 0, 6).substr(md5($rssData->getDescription($i)), 0, 6).substr(md5($rssData->getLink($i)), 0, 6));
                $article->pubdate = $rssData->getPubdate($i);
                $article->pubdateTimestamp = strtotime($rssData->getPubdate($i));
                $article->feed_id = $newFeed->id;
                $article->save();
            } catch (ErrorException $ex) {}
        }

        return redirect('/manager');
    }
}
