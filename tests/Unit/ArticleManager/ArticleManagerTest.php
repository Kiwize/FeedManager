<?php

namespace Tests\Unit\ArticleManager;

use App\Managers\ArticleManager;
use App\Managers\FeedManager;
use App\Managers\RSSData;
use App\Models\Feed;
use ErrorException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

class ArticleManagerTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreateAllArticlesFromFeed()
    {
        $testRSSData = new RSSData("https://inessential.com/feed.json");
        $testFeed = FeedManager::create("unit_test_feed_00", "https://inessential.com/feed.json");
        assertTrue(ArticleManager::createAllArticles($testRSSData, $testFeed->id));

        assertFalse(ArticleManager::createArticle($testRSSData, -1, $testFeed->id));

        Feed::where("link", "=", "https://inessential.com/feed.json")->delete();
    }
}