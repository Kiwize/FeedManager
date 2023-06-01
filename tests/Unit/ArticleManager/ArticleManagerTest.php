<?php

namespace Tests\Unit\ArticleManager;

use ErrorException;
use Tests\TestCase;
use App\Models\Feed;
use App\Managers\RSSData;
use App\Managers\FeedManager;
use App\Managers\ArticleManager;
use function PHPUnit\Framework\assertTrue;
use function PHPUnit\Framework\assertFalse;

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

        // $this->expectException(UnexpectedValueException::class);
        // ArticleManager::createAllArticlesArray(array("https://youtube.com"));

        // $this->expectException(ErrorException::class);
        // ArticleManager::createAllArticlesArray(array("https://hqsdhfqsjf.com"));
    }
}
