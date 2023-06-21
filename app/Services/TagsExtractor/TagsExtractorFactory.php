<?php

declare(strict_types=1);

namespace App\Services\TagsExtractor;

use App\Services\TagsExtractor\Adapters\PhpmlAdapter;
use App\Services\TagsExtractor\Adapters\RakePlusAdapter;
use App\Services\TagsExtractor\Adapters\TagsExtractorLibraryInterface;
use App\Services\TagsExtractor\Adapters\TextRankAdapter;
use Exception;
use Illuminate\Support\Facades\Log;

/**
 * TagsExtractorFactory
 * 
 * Use the right tags extarctor library
 */
class TagsExtractorFactory
{

    private static $instance = null;

    /**
     * adapter
     *
     * @var TagsExtractorLibraryInterface
     */
    private $tagExtractorLibrary;


    /**
     * __construct
     *
     * @return void
     */
    private function __construct()
    {
    }

    /**
     * getInstance
     *
     * @return TagsExtractorFactory
     */
    public static function getInstance(): TagsExtractorFactory
    {
        if (self::$instance === null) {
            self::$instance = new TagsExtractorFactory();
        }
        return self::$instance;
    }

    /**
     * getClient
     *
     * @param  string $param
     * @return TagsExtractorLibraryInterface
     */
    public static function getClient(string $param): TagsExtractorLibraryInterface
    {
        switch ($param) {
            case 'rakeplus':
                self::$instance->tagExtractorLibrary = new RakePlusAdapter();
                break;
            case 'textrank':
                self::$instance->tagExtractorLibrary = new TextRankAdapter();
                break;
            case 'phpml':
                self::$instance->tagExtractorLibrary = new PhpmlAdapter();
                break;

            default:
                Log::error('Unrecognized tag extractor library');
                throw new Exception('Unrecognized tag extractor library');
                break;
        }
        return self::$instance->tagExtractorLibrary;
    }
}
