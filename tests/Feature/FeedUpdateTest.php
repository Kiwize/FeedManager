<?php

namespace Tests\Feature;

use App\Managers\ArticleManager;
use App\Managers\FeedManager;
use App\Managers\FeedUpdater;
use App\Models\Article;
use App\Models\Feed;
use Carbon\Carbon;
use Database\Factories\ArticleFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertGreaterThan;
use function PHPUnit\Framework\assertIsArray;

class FeedUpdateTest extends TestCase
{
    use DatabaseTransactions;

    public function testFeedUpdate()
    {
        $response = $this->get('/article-refresh-request');
        $response->assertStatus(200);
        assertIsArray(FeedUpdater::update());
    }

    public function testArticleCreationOnUpdate() {
        FeedManager::create("unit_test_feed_00", "https://inessential.com/feed.json");
        Article::select('*')->delete();
        $result = FeedUpdater::update();
        assertIsArray($result);
        assertGreaterThan(0, $result['addedArticles']);
    }

    public function testArticleContentUpdate() {
        FeedManager::create("unit_test_feed_00", "https://inessential.com/feed.json");
        FeedManager::create("unit_test_feed_01", "https://korben.info/feed");
        ArticleManager::createAllArticlesArray(array( "https://inessential.com/feed.json", "https://korben.info/feed"));

        $articles = Article::all();
        foreach($articles as $article) {
            $article->dynamic_hash = Str::random(4);
            $article->save();
        }

        $result = FeedUpdater::update();
        
        assertIsArray($result);
        assertGreaterThan(0, $result['modifiedArticles']);
    }

    public function testUpdateUnchange() {
        FeedManager::create("unit_test_feed_01", "https://inessential.com/feed.json");
        $result = FeedUpdater::update();
        assertIsArray($result);
        assertGreaterThan(0, FeedUpdater::update()['unchangedArticles']);
    }
}
