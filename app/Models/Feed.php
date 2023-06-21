<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Feed extends Model
{
    protected $table = 'feeds';

    protected $fillable = ['name', 'link', 'locale'];
    
    /**
     * articles
     *
     * @return HasMany
     */
    public function articles(): HasMany {
        return $this->hasMany('Article');
    }

    protected $casts = ['rssdata' => 'array'];
}
