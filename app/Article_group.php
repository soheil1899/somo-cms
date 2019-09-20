<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article_group extends Model
{
    public function keywords()
    {
        return $this->hasMany(Keyword::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class)->orderBy('ordered');
    }
    public function lang()
    {
        return $this->belongsTo(Lang::class);
    }

}
