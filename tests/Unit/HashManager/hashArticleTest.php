<?php

namespace App\Managers;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertIsString;
use function PHPUnit\Framework\assertNull;

class hashArticleTest extends TestCase{

    public function testHashArticle() {

        $hashManager = new HashManager;
        $testRSSData = new RSSData("https://inessential.com/feed.json");

        $result = $hashManager->hashArticle($testRSSData, 0);

        assertIsArray($result);

        $result = $hashManager->hashArticle($testRSSData, 500);

        assertIsArray($result);
        assertCount(0, $result);
    }
    
    /**
     * testHashRSSFile
     *
     * @return void
     */
    public function testHashRSSFile() {
        $hashManager = new HashManager;
        $result = $hashManager->hashRSSFile("https://inessential.com/feed.json");

        assertIsString($result);        
    }
}