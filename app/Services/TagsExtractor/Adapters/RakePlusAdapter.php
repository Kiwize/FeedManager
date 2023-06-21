<?php

declare(strict_types=1);

namespace App\Services\TagsExtractor\Adapters;

use DonatelloZa\RakePlus\RakePlus;
use Exception;

class RakePlusAdapter implements TagsExtractorLibraryInterface
{

    public function getResult(string $text, array $stopWords): array
    {
        $response = [];

        try {
            $response = RakePlus::create($text, $stopWords, 2, true)->keywords();
        } catch (Exception $e) {
            \var_dump($e->getMessage());
        }

        return $response;
    }
}
