<?php

namespace Tests\Feature;

use App\Managers\FeedManager;
use App\Managers\FeedUpdater;
use App\Models\Feed;
use Tests\TestCase;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertIsArray;

class FeedUpdateTest extends TestCase
{
    public function testFeedUpdate()
    {
        $response = $this->get('/article-refresh-request');
        $response->assertStatus(200);

        assertIsArray(FeedUpdater::update());
    }

    public function testFeedUpdateNewFeed() {
        $feeds = FeedManager::getFromLink("https://inessential.com/feed.json");

        foreach($feeds as $feed) {
            FeedManager::delete($feed->id);
        }

        assertFalse(FeedManager::exists("https://inessential.com/feed.json"));
        FeedManager::create("unit_test_feed_00", "https://inessential.com/feed.json");
        Feed::where('name', '=', "unit_test_feed_01")->delete();
        FeedManager::create("unit_test_feed_01", "https://www.mediapart.fr/articles/feed?userid=3889de42-d648-4812-85bc-2fbdef626c24");
        $result = FeedUpdater::update();

        assertIsArray($result);
    }

    public function testUpdateUnchange()
    {
        FeedManager::create("unit_test_feed_01", "https://www.mediapart.fr/articles/feed?userid=3889de42-d648-4812-85bc-2fbdef626c24");

        $result = FeedUpdater::update();

        assertIsArray($result);
    }
}
