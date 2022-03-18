<?php

namespace Tests\Unit;

use App\Managers\FeedUpdater;
use Tests\TestCase;

class ArticleHashTest extends TestCase
{ 
    public function test_example()
    {
        $result = FeedUpdater::update();
        fwrite(STDERR, print_r($result, TRUE));
        $this->assertNotNull($result);
    }
}
