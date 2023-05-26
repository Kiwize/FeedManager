<?php

namespace Database\Seeders;

use App\Managers\FeedManager;
use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleSeeder extends Seeder
{
    use RefreshDatabase;

    public function run()
    {
        FeedManager::create("feed_article_factory", "https://inessential.com/feed.json");
        Article::newFactory()->count(35565)->create();
    }
}
