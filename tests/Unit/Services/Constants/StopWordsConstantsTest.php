<?php

namespace Tests\Unit\Services\TagsExtractor;

use App\Services\TagsExtractor\Constants\StopWordsConstants;
use Illuminate\Testing\Assert;
use Tests\TestCase;

class StopWordsConstantsTest extends TestCase
{
    public function testClassAttributes()
    {
        Assert::assertIsArray(StopWordsConstants::$stopWords);
    }

    public function testStopwordsFr()
    {
        Assert::assertIsArray(StopWordsConstants::$stopWords['fr']);
    }

    public function testStopwordsEn()
    {
        Assert::assertIsArray(StopWordsConstants::$stopWords['en']);
    }
}
