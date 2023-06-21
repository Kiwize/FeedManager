<?php

declare(strict_types=1);

namespace App\Services\TagsExtractor\Adapters;

use PhpScience\TextRank\TextRankFacade;

class TextRankAdapter implements TagsExtractorLibraryInterface
{

    public function getResult(string $text, array $stopWords): array
    {
        $api = new TextRankFacade();

        // Array of the most important keywords:
        $resultWithPoints = $api->getOnlyKeyWords($text);
        $tags = \array_keys($resultWithPoints);
        $response = array_diff($tags, $stopWords);

        return $response;
    }
}
