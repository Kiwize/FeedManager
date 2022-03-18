<?php

namespace App\Managers;

use App\Models\Article;

class HashManager {
    public function hashArticle($article): array {
        return array(
            'staticHash' => (string)(substr(md5((strtotime($article->pubDate).substr(md5($article->guid), 0, 6))), 0, 8)), 
            'dynamicHash' => (string)(substr(md5($article->title), 0, 6).substr(md5($article->description), 0, 6).substr(md5($article->link), 0, 6)));
    }

    public function hashRSSFile($url): string {
        return hash("sha256", file_get_contents($url));
    }
}