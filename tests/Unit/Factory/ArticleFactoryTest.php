<?php

namespace Tests\Unit\Factory;
use App\Models\Article;
use Illuminate\Support\Str;
use Tests\TestCase;

use function PHPUnit\Framework\assertTrue;

class ArticleFactoryTest extends TestCase {

    public function testArticleFactory() {
        $articles = Article::newFactory()->count(35565)->create();
        // assertTrue(true);
    }

}