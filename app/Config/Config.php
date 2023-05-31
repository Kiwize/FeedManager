<?php

namespace App\Config;

class Config {

    const ARTICLES_PER_PAGES = 6;

    public static function getArticlesPerPages(): int {
        return self::ARTICLES_PER_PAGES;
    }
}

