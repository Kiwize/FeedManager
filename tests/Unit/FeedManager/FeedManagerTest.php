<?php

namespace Tests\Unit\FeedManager;

use App\Managers\FeedManager;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertTrue;

class FeedManagerTest extends TestCase
{
    use DatabaseTransactions;

    public function testFeedCreation() {
        $feed = FeedManager::create('unit_test_feed_00', "https://inessential.com/feed.json");
        $this->assertDatabaseHas('feeds', [
            'name' => 'unit_test_feed_00',
            'link' => 'https://inessential.com/feed.json'
        ]);
    }

    public function testFeedExists() {
        FeedManager::create('unit_test_feed_00', "https://inessential.com/feed.json");
        assertTrue(FeedManager::exists("https://inessential.com/feed.json"));
    }

    public function testFeedDeletion() {
        assertIsArray($feeds = FeedManager::getFromLink("https://inessential.com/feed.json"));

        foreach($feeds as $feed) {
            FeedManager::delete($feed->id);
        }

        assertFalse(FeedManager::exists("https://inessential.com/feed.json"));
    }

    public function testGetAllIds() {
        assertIsArray(FeedManager::getAllIDs());
    }
}
