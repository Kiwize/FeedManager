<?php
namespace Tests\Unit\Controller;

use App\Managers\FeedManager;
use App\Models\Feed;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FeedControllerTest extends TestCase {
    
    use DatabaseTransactions;
    public function testGetFeedList() {
        $response = $this->get("/api/feeds");
        $response->assertStatus(200);
    }

    public function testDeleteFeed() {
        $response = $this->delete("/api/feeds/delete", []);
        $response->assertStatus(400);

        $response = $this->delete("/api/feeds/delete", [
            'feedID' => Feed::first()->id
        ]);

        $response->assertStatus(204);

        $response = $this->delete("/api/feeds/delete", [
            'feedID' => 9999
        ]);
        $response->assertStatus(404);
    }

    public function testAddFeed() {
        $response = $this->put("/api/feeds/create", []);
        $response->assertStatus(400);

        $response = $this->put("/api/feeds/create", [
            'name' => 'unit_test_feed_00',
            'link' => 'https://inessential.com/feed.json'
        ]);
        
        $response->assertStatus(400);

        Feed::where('link', '=', 'https://inessential.com/feed.json')->delete();

        $response = $this->put("/api/feeds/create", [
            'name' => 'unit_test_feed_00',
            'link' => 'https://inessential.com/feed.json'
        ]);

        $response->assertStatus(201);
    }
}