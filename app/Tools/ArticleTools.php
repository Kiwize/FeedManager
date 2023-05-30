<?php

namespace App\Tools;
class ArticleTools {

     /**
     * parseDate
     * Parse la date de publication en un tableau d'entiers correspondants à l'année, le mois, le jour, l'heure, la minute et la seconde de
     * la date de publication de l'article concerné.
     * @param  mixed $pubdate Date de publication au format YYYY-MM-DD HH:mm:ss
     * @return array Tableau d'entiers
     */
    public static function parseDate($pubdate): array
    {
        return array_values(array_slice(date_parse($pubdate), 0, 6));
    }

}