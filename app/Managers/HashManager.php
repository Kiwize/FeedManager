<?php

namespace App\Managers;

use Exception;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\ExceptionWrapper;

class HashManager
{
    /**
     * hashArticle
     * Calcule le hash d'un article du flux passé en paramètre, l'id est celui de l'article.
     * Retourne un tableau vide si l'id est invalide
     * @param  mixed $article
     * @return array
     */
    public function hashArticle(RSSData $rssData, int $id): array
    {
        if ($rssData->getArticleCount() > $id - 1 && $id >= 0)
            return array(
                'static_hash' => (string) (substr(md5((strtotime($rssData->getPubdate($id)) . substr(md5($rssData->getGUID($id)), 0, 6))), 0, 8)),
                'dynamic_hash' => (string) (substr(md5($rssData->getTitle($id)), 0, 6) . substr(md5($rssData->getDescription($id)), 0, 6))
            );
        else
            return array();
    }

    /**
     * hashRSSFile
     * Retourne le hash sha256 de l'intégralité du contenu du flux.
     * @param  string $url URL du flux RSS
     * @return ?string Renvoie le hash si la source est valide | null en cas d'erreur.
     */
    public function hashRSSFile(string $url): ?string
    {
        try {
            return hash("sha256", file_get_contents($url));
        } catch (Exception $ex) {
            return null;
        }
    }
}
