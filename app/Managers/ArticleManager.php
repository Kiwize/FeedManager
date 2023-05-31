<?php


namespace App\Managers;

use DateTime;
use Carbon\Carbon;
use ErrorException;
use App\Models\Feed;
use App\Models\Article;
use App\Managers\RSSData;
use App\Tools\ArticleTools;
use App\Managers\FeedManager;
use App\Managers\HashManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ArticleManager
{

    /**
     * createAllArticles
     * Ajoute en base de données tous les articles d'un flux. La fonction s'arrète au moment où
     * un article ne peux pas être ajouté.
     * @param  mixed $rssData Données RSS
     * @param  mixed $feedID ID du flux
     * @return bool true si tous les articles ont été ajoutés, false sinon.
     */
    public static function createAllArticles(RSSData $rssData, int $feedID): bool
    {   
        DB::beginTransaction();
        $articles = array();

        for ($x = 0; $x < $rssData->getArticleCount(); $x++) {
            $article = ArticleManager::getArticle($rssData, $x, $feedID);
            if(is_null($article))
                return false;
            else
                array_push($articles, $article->toArray());
        }

        Article::insert($articles);
        DB::commit();
        return true;
    }
    
    /**
     * createAllArticlesArray
     * Permet d'ajouter tous les articles de plusieurs flux.
     * @param  mixed $rssDataURLs URLs des flux RSS
     * @return bool true si tous les articles ont été ajoutés, false sinon.
     */
    public static function createAllArticlesArray(array $rssDataURLs):bool {
        foreach($rssDataURLs as $url) {
            $testRSSData = new RSSData($url);
            $testFeed = FeedManager::create("unit_test_feed", $url);
            if(ArticleManager::createAllArticles($testRSSData, $testFeed->id) === false)
                return false;           
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
        try {
            $newArticle = ArticleManager::getArticle($rssData, $id, $feedID);
            $newArticle->save();
            return true;
        } catch (ErrorException $ex) {
            Log::error('Unable to create article, malformed RSS Feed !\n' . $ex);
            return false;
        }
    }
    
    /**
     * getArticle
     * Permet de récupérer un article précis d'un flux RSS.
     * @param  mixed $rssData Données du flux RSS
     * @param  mixed $id ID de l'article dans le flux
     * @param  mixed $feedID ID du flux dans la base de données
     * @return Article Si l'article a été trouvé.
     * @return null Si une erreur s'est produite.
     */
    public static function getArticle(RSSData $rssData, int $id, int $feedID): ?Article {
        $hm = new HashManager;
        $hashes = $hm->hashArticle($rssData, $id);
        $newArticle = new Article;
        try {
            $carbonDate = new Carbon(new DateTime($rssData->getPubdate($id)));
            $newArticle->title = $rssData->getTitle($id);
            $newArticle->description = $rssData->getDescription($id);
            $newArticle->link = $rssData->getLink($id);
            $newArticle->static_hash = $hashes['static_hash'];
            $newArticle->dynamic_hash = $hashes['dynamic_hash'];
            $newArticle->pubdate = Carbon::parse($carbonDate);
            $newArticle->feed_id = $feedID;
        } catch (ErrorException $ex) {
            Log::error('Unable to create article, malformed RSS Feed !\n' . $ex);
            return null;
        }

        return $newArticle;
    }
    
    /**
     * toJson
     * Convertit un article en un objet JSON compatible pour la MMI
     * @param  mixed $article 
     * @return array Object JSON formatté pour la MMI
     */
    public static function toJson($article): array
    {
        $response = array();
        $feed = Feed::where('id', "=", $article->feed_id)->first();

        $formattedArticle =
            array(
                "title" => $article->title,
                "title_detail" => [
                    "type" => "text/plain",
                    "language" => "null",
                    "base" => "",
                    "value" => $article->title
                ],
                "links" => [
                    "rel" => "alternate",
                    "type" => "text/html",
                    "href" => $article->link
                ],
                "link" => $article->link,
                "summary" => $article->description,
                "summary_detail" => [
                    "type" => "text/html",
                    "language" => "null",
                    "base" => "",
                    "value" => $article->description
                ],
                "authors" => ["name" => $feed->link],
                "author" => $feed->link,
                "author_detail" => [
                    "name" => $feed->link,
                    "published" => $article->pubdate,
                    "published_parsed" => [
                        ArticleTools::parseDate($article->pubdate)
                    ],
                    "source" =>
                    [
                        "href" => $feed->link,
                        "title" => $feed->name
                    ]
                ]
            );
        array_push($response, $formattedArticle);
        return $response;
    }

    /**
     * sortArticles
     * Trie les articles selont leurs titre ou date de publication. 
     * @param  string $searchFilter
     * @return array
     */
    public static function sortArticles(string $searchFilter): array
    {

        switch ($searchFilter) {
            case "oldest":
                $articles = Article::orderBy('pubdate', 'ASC')->get();
                break;

            case "alphabetTitle":
                $articles = Article::orderBy('title')->get();
                break;

            default:
                $articles = Article::orderBy('pubdate', 'DESC')->get();
        }

        $filteredArticles = array();
        foreach ($articles as $filteredArticle) {
            array_push($filteredArticles, $filteredArticle);
        }

        return $filteredArticles;
    }
}