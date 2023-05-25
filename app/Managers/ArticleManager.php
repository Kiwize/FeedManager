<?php


namespace App\Managers;

use App\Models\Article;
use App\Models\Feed;
use ErrorException;
use Illuminate\Support\Facades\Log;

class ArticleManager
{
    
    /**
     * createAllArticles
     * Ajoute en base de données tous les articles d'un flux. La fonction s'arrète au moment où
     * un article ne peux pas être ajouté.
     * @param  mixed $rssData Données RSS
     * @param  mixed $feedID ID du flux
     * @return bool true si les articles ont été ajoutés, false sinon.
     */
    public static function createAllArticles(RSSData $rssData, int $feedID) : bool{
        for($x = 0; $x < $rssData->getArticleCount(); $x++) {
            if(ArticleManager::createArticle($rssData, $x, $feedID) === false) return false;
        }

        return true;
    }
    
    /**
     * createArticle
     * Ajoute un article d'un flux dans la base de données.
     * @param  mixed $rssData Données RSS
     * @param  mixed $id ID de l'article dans le flux RSS
     * @param  mixed $feedID ID du flux
     * @return bool True si l'article à été ajouté, false sinon
     */
    public static function createArticle(RSSData $rssData, int $id, int $feedID): bool
    {
        $hm = new HashManager;
        $hashes = $hm->hashArticle($rssData, $id);

        try {
            $newArticle = new Article;
            $newArticle->title = $rssData->getTitle($id);
            $newArticle->description = $rssData->getDescription($id);
            $newArticle->link = $rssData->getLink($id);
            $newArticle->guid = $rssData->getGUID($id);
            $newArticle->static_hash = $hashes['static_hash'];
            $newArticle->dynamic_hash = $hashes['dynamic_hash'];
            $newArticle->pubdate = $rssData->getPubdate($id);
            $newArticle->pubdate_timestamp = strtotime($rssData->getPubdate($id));
            $newArticle->feed_id = $feedID;
            $newArticle->save();
            return true;
        } catch (ErrorException $ex) {
            Log::error('Unable to create article, malformed RSS Feed !\n'.$ex);
            $newArticle->delete();
            return false;
        }
    }

        
    /**
     * sortArticles
     * Trie les articles selont leurs titre ou date de publication. 
     * @param  string $searchFilter
     * @return array
     */
    public static function sortArticles(string $searchFilter): array {

        switch ($searchFilter) {
            case "oldest":
                $articles = Article::orderBy('pubdate_timestamp', 'ASC')->get();
                break;

            case "alphabetTitle":
                $articles = Article::orderBy('title')->get();
                break;

            default:
                $articles = Article::orderBy('pubdate_timestamp', 'DESC')->get();
        }
        
        $filteredArticles = array();
        foreach($articles as $filteredArticle) {
            array_push($filteredArticles, $filteredArticle);
        }

        return $filteredArticles;
    }
}
