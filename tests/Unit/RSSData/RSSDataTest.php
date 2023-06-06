<?php

namespace Tests\Unit\RSSData;

use App\Managers\RSSData;
use Tests\TestCase;

use UnexpectedValueException;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertIsString;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNull;

class RSSDataTest extends TestCase
{

    public function testCreateRSSData()
    {
        $testRSSData = new RSSData("https://inessential.com/feed.json");

        assertNotNull($testRSSData);
        assertInstanceOf(RSSData::class, $testRSSData);
    }

    public function testRSSDataType()
    {
        $testRSSData = new RSSData("https://inessential.com/feed.json");
        assertEquals("json", $testRSSData->getType());
        $testRSSData = new RSSData("https://www.lemondeinformatique.fr/flux-rss/thematique/virtualisation/rss.xml");
        assertEquals("xml", $testRSSData->getType());
        $testRSSData = new RSSData("https://www.mediapart.fr/articles/feed?userid=3889de42-d648-4812-85bc-2fbdef626c24");
        assertEquals("xml", $testRSSData->getType());

        $this->expectException(UnexpectedValueException::class);
        $testRSSData = new RSSData("abcdefg");

        $this->expectException(UnexpectedValueException::class);
        $testRSSData = new RSSData("https://youtube.com");

        $this->expectException(Exception::class);
        $testRSSData = new RSSData("https://youtube.com");
    }

    public function testGetUrl()
    {
        $testRSSData = new RSSData("https://inessential.com/feed.json");
        assertIsString($testRSSData->getURL());
    }

    public function testGetArticleLink()
    {
        $jsonData = new RSSData("https://inessential.com/feed.json");
        $xmlData = new RSSData("https://www.lemondeinformatique.fr/flux-rss/thematique/virtualisation/rss.xml");
        assertIsString($jsonData->getLink(0));
        assertIsString($xmlData->getLink(0));
    }

    public function testGetLocale()
    {
        $jsonData = new RSSData("https://inessential.com/feed.json");
        $xmlData = new RSSData("https://www.mediapart.fr/articles/feed?userid=065ba7dd-f62c-4e8a-b70f-b2c3215802d1");
        assertIsString($jsonData->getLocale());
        assertIsString($xmlData->getLocale());
        assertEquals($jsonData->getLocale(), "en");
        assertEquals($xmlData->getLocale(), "fr");
    }
}
