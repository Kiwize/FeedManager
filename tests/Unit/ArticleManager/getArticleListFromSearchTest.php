<?php

namespace Tests\Unit\ArticleManager;

use App\Managers\ArticleManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertNotNull;

class getArticleListFromSearchTest extends TestCase
{
    /**
     * Vérifie si la recherche retourne un array
     * @return void
     */
    public function testGetArticleFromSearchIsArray()
    {
        $result = ArticleManager::sortArticles("test");
        assertIsArray($result);
        $result = ArticleManager::sortArticles("");
        assertIsArray($result);
        $result = ArticleManager::sortArticles("oldest");
        assertIsArray($result);
        $result = ArticleManager::sortArticles("alphabetTitle");
        assertIsArray($result);
    }
    
    /**
     * testGetArticleFromSearchNotNull
     * Vérifie si la recherche ne renvoie pas de résultat nul
     * @return void
     */
    public function testGetArticleFromSearchNotNull()
    {
        $result = ArticleManager::sortArticles("test");
        assertNotNull($result);
        $result = ArticleManager::sortArticles("");
        assertNotNull($result);
        $result = ArticleManager::sortArticles("oldest");
        assertNotNull($result);
        $result = ArticleManager::sortArticles("alphabetTitle");
        assertNotNull($result);
    }


}
