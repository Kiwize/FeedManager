<?php

declare(strict_types=1);

namespace App\Services\TagsExtractor;

use App\Services\TagsExtractor\Adapters\TagsExtractorLibraryInterface;
use App\Services\TagsExtractor\Constants\StopWordsConstants;
use App\Services\TagsExtractor\Constants\TagsExtractorConstants;
use Exception;

class TagsExtractorService
{

    /**
     * getResult
     *
     * @param  string $param
     * @param  string $text
     * @return array
     */
    public function getResult(string $param, string $text): array
    {
        $cleanText = $this->cleanText($text);
        /** @var TagsExtractorLibraryInterface */
        $client = TagsExtractorFactory::getInstance()->getClient($param);
        $extractedResult = $client->getResult($cleanText, $this->getStopWords());
        $result = $this->deleteSmallWordsFromArray($extractedResult, 2);
        return $result;
    }
    /**
     * cleanText
     *
     * @param  string $text
     * @return string
     */
    public function cleanText(string $text): string
    {
        return str_replace(TagsExtractorConstants::$charsToOmit, ' ', strtolower($text));
    }

    /**
     * deleteSmallWordsFromArray
     * Can specify the min length and if we want to keep numeric
     *
     * @param  array $wordList
     * @param  int $minLength
     * @param  true $keepNumber
     * @return array
     */
    public function deleteSmallWordsFromArray(array $wordList, int $minLength = 2, $keepNumber = false): array
    {
        foreach ($wordList as $key => $word) {
            if ($keepNumber &&  \is_numeric($word)) {
                continue;
            }
            $strWord = strval($word);
            if (strlen($strWord) <= $minLength) {
                unset($wordList[$key]); // Remove words with length less than $minLength
            }
        }
        return $wordList;
    }


    /**
     * extractCve
     *
     * @param  string $text
     * @return void
     */
    public function extractCve(string $text)
    {
        $cveList = [];
        $pattern = "/CVE-\d{4}-\d{4,9}/i";

        if (preg_match_all($pattern, $text, $matches)) {
            $cveList = array_unique($matches[0]);
        }
        // put to lower case
        foreach ($cveList as &$value)
            $value = \strtoupper($value);

        return $cveList;
    }

    /**
     * extractExtraWords
     *
     * @param  string $text
     * @return array
     */
    public function extractExtraWords(string $text): array
    {
        $response = [];
        $keywords = TagsExtractorConstants::$keywords ?? [];

        $pattern = '/\b(' . implode('|', array_map('preg_quote', $keywords)) . ')\b/i'; // Expression régulière dynamique


        if (preg_match_all($pattern, $text, $matches)) {
            $response = array_unique($matches[0]); // Supprimer les doublons
        }
        foreach ($response as &$value)
            $value = strtolower($value);

        return $response;
    }

    /**
     * getStopWords
     *
     * @param  mixed $locale
     * @return array
     */
    public function getStopWords(string $locale = 'fr'): array
    {
        if (false === array_key_exists($locale, StopWordsConstants::$stopWords)) {
            throw new Exception('This locale for stop words is unknow');
        }
        return StopWordsConstants::$stopWords[$locale];
    }
}
