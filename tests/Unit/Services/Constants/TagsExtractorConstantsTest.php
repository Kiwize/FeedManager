<?php

namespace Tests\Unit\Services\TagsExtractor;

use App\Services\TagsExtractor\Constants\TagsExtractorConstants;
use Illuminate\Testing\Assert;
use Tests\TestCase;

class TagsExtractorConstantsTest extends TestCase
{
    public function testClassAttributes()
    {
        Assert::assertIsArray(TagsExtractorConstants::$keywords);
        Assert::assertIsArray(TagsExtractorConstants::$charsToOmit);
    }
}
