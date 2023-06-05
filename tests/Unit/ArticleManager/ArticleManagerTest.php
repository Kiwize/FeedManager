<?php

namespace Tests\Unit\ArticleManager;

use Database\Factories\ArticleFactory;
use ErrorException;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\Feed;
use App\Managers\RSSData;
use App\Managers\FeedManager;
use App\Managers\ArticleManager;
use function PHPUnit\Framework\assertTrue;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertIsArray;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use UnexpectedValueException;

class ArticleManagerTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreateAllArticlesFromFeed()
    {
        $rssURL = array(
            "https://inessential.com/feed.json"
        );

        assertTrue(ArticleManager::createAllArticlesArray($rssURL));
        $this->expectException(UnexpectedValueException::class);
        ArticleManager::createAllArticlesArray(array("https://youtube.com"));
        $this->expectException(ErrorException::class);
        ArticleManager::createAllArticlesArray(array("https://hqsdhfqsjf.com"));
    }

    public function testToJSON() {
        FeedManager::create("unit_test_feed_00", "https://inessential.com/feed.json");
        $article = ArticleFactory::new()->count(1)->make()->first();
        assertIsArray(ArticleManager::toJson($article));
    }

    public function testCreateArticle() {
        $rssData = new RSSData("https://inessential.com/feed.json");
        FeedManager::create("unit_test_feed_00", "https://inessential.com/feed.json");
        assertTrue(ArticleManager::createArticle($rssData, 0, Feed::all()->first()->id));
        assertFalse(ArticleManager::createArticle($rssData, -1, Feed::all()->first()->id));
    }
}
