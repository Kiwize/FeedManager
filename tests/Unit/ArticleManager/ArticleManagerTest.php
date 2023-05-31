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
            'https://www.01net.com/feed/',
            'https://www.abondance.com/feed',
            'http://feeds.feedburner.com/bhmag',
            'https://www.clubic.com/articles.rss',
            'https://www.commentcamarche.net/forum/actualites-high-tech-8?fmt=rss',
            'http://feeds.feedburner.com/cowcotland',
            'http://feeds.feedburner.com/ConseilConfig',
            'https://www.configspc.com/feed/',
            'https://www.cnetfrance.fr/feeds/rss/'
        );

        assertTrue(ArticleManager::createAllArticlesArray($rssURL));

        $this->expectException(UnexpectedValueException::class);
        ArticleManager::createAllArticlesArray(array("https://youtube.com"));

        $this->expectException(ErrorException::class);
        ArticleManager::createAllArticlesArray(array("https://hqsdhfqsjf.com"));
    }
}
