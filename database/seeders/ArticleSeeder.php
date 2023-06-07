<?php

namespace Database\Seeders;

use App\Managers\FeedManager;
use Database\Factories\ArticleFactory;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        FeedManager::create("feed_article_factory", "https://inessential.com/feed.json");
        ArticleFactory::new()->count(10)->create();
    }
}
