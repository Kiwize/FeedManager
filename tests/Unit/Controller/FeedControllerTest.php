<?php
namespace Tests\Unit\Controller;

use App\Managers\FeedManager;
use App\Models\Feed;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FeedControllerTest extends TestCase {
    
    use DatabaseTransactions;
    public function testGetFeedList() {
        $response = $this->get("/feed-getlist-request");
        $response->assertStatus(200);
    }

    public function testDeleteFeed() {
        $response = $this->post("/feed-delete-request", []);
        
        $response->assertStatus(400);

        $response = $this->post("/feed-delete-request", [
            'feedID' => Feed::first()->id
        ]);

        $response->assertStatus(200);

        $response = $this->post("/feed-delete-request", [
            'feedID' => 9999
        ]);

        $response->assertStatus(400);
    }

    public function testAddFeed() {
        $response = $this->post("/api/events", []);
        $response->assertStatus(400);

        $response = $this->post("/api/events", [
            'name' => 'unit_test_feed_00',
            'link' => 'https://inessential.com/feed.json'
        ]);
        
        $response->assertStatus(400);

        FeedManager::delete(FeedManager::getFromLink('https://inessential.com/feed.json')->id);

        $response = $this->post("/api/events", [
            'name' => 'unit_test_feed_00',
            'link' => 'https://inessential.com/feed.json'
        ]);

        $response->assertStatus(201);
    }
}