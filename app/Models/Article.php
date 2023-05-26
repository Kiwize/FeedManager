<?php

namespace App\Models;

use Carbon\Factory;
use Database\Factories\ArticleFactory;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory as FactoriesFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    protected $table = 'articles';

    protected $fillable = ['title', 'link', 'decription'];
    
    /**
     * feed
     *
     * @return BelongsTo
     */
    public function feed(): BelongsTo {
        return $this->belongsTo('Feed');
    }

    protected static function newFactory(): FactoriesFactory {
        return ArticleFactory::new();
    }
}
