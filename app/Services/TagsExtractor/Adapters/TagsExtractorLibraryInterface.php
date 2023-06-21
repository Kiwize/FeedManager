<?php

declare(strict_types=1);

namespace App\Services\TagsExtractor\Adapters;

interface TagsExtractorLibraryInterface
{
    /**
     * getResult
     *
     * @param  string $text
     * @return array
     */
    public function getResult(string $text, array $stopWords): array;
}
