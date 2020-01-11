<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article_group extends Model
{

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

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
