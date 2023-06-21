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

        $response = $this->get("/api/feeds?locale_filter=fr");
        $response->assertStatus(200);

        $response = $this->post("/api/feeds/search", []);

        $response->assertStatus(200);

        $response = $this->post("/api/feeds/search", [
            'nameFilter' => "a",
            "localeFilter" => "fr"
        ]);

        $response->assertStatus(200);

        $response = $this->post("/api/feeds/search", [
            'nameFilter' => "a",
            "localeFilter" => "frsqd"
        ]);

        $response->assertStatus(400);
    }

    public function testDeleteFeed() {
        $response = $this->delete("/api/feeds/delete", []);
        $response->assertStatus(400);

        Feed::create(['name' => 'unit_test_feed', 'link' => 'https://inessential.com/feed.json', 'locale' => 'en']);

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
        $response = $this->post("/api/feeds/create", []);
        $response->assertStatus(400);

        $response = $this->post("/api/feeds/create", [
            'name' => 'unit_test_feed_00',
            'link' => 'https://inessential.com/feed.json'
        ]);
        
        $response->assertStatus(201);

        Feed::where('link', '=', 'https://inessential.com/feed.json')->delete();

        $response = $this->post("/api/feeds/create", [
            'name' => 'unit_test_feed_00',
            'link' => 'https://inessential.com/feed.json',
            'author_logo' => 'https://inessential.com/feed.json'
        ]);

        $response->assertStatus(201);

        $response = $this->post("/api/feeds/create", [
            'name' => 'unit_test_feed_00',
            'link' => 'https://inessential.com/feed.json',
            'author_logo' => 'https://inessential.com/feed.json'
        ]);

        $response->assertStatus(400);
    }
}
