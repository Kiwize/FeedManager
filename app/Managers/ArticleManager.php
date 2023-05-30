<?php


namespace App\Managers;

use App\Models\Article;
use App\Models\Feed;
use App\Tools\ArticleTools;
use Carbon\Carbon;
use DateTime;
use ErrorException;
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
     * @return bool true si les articles ont été ajoutés, false sinon.
     */
    public static function createAllArticles(RSSData $rssData, int $feedID): bool
    {
        DB::beginTransaction();
        for ($x = 0; $x < $rssData->getArticleCount(); $x++) {
            if (ArticleManager::createArticle($rssData, $x, $feedID) === false) {
                DB::rollBack();
                return false;              
            }     
        }
        DB::commit();
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
            $newArticle->save();
            return true;
        } catch (ErrorException $ex) {
            Log::error('Unable to create article, malformed RSS Feed !\n' . $ex);
            $newArticle->delete();
            return false;
        }
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