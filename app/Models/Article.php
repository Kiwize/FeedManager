<?php

namespace App\Models;

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
}
