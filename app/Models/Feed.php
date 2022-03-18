<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    protected $table = 'feeds';

    public function articles() {
        return $this->hasMany('Article');
    }

    protected $casts = ['rssdata' => 'array'];
}
