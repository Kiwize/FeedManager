<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TagsExtractor\TagsExtractorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    /**
     * tagsExtractorService
     *
     * @var TagsExtractorService
     */
    protected TagsExtractorService $tagsExtractorService;

    public function __construct(TagsExtractorService $tagsExtractorService)
    {
        $this->tagsExtractorService = $tagsExtractorService;
    }

    /**
     * Recherche les tags d'un texte
     * 
     * 
     * @param  Request $request (mandatories: text, optionnals: limit)
     * @return JsonResponse
     * @method POST /api/tags
     */
    public function fetch(Request $request): JsonResponse
    {
        $body = $request->all();

        // $text = \array_key_exists('text', $body);
        $text = $body['text'] ?? '';
        $limit = $body['limit'] ?? 10;

        $start = microtime(true);

        // construct response
        $response = [];

        // Find CVE in text
        $cveList = $this->tagsExtractorService->extractCve($text);
        $response = \array_merge($response, $cveList);

        // Find specifics words in text
        $extractedHilighWords = $this->tagsExtractorService->extractExtraWords($text);
        $response = \array_merge($response, $extractedHilighWords);

        $this->tagsExtractorService->getStopWords('fr');

        $tags = $this->tagsExtractorService->getResult('phpml', $text);
        $limitedTags = \array_slice($tags, 0, $limit);
        $response = \array_merge($response, $limitedTags);

        $timeElapsedMs = (microtime(true) - $start) * 1000;

        return response()->json($response);
    }
}
