<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article_type extends Model
{


    public function contents()
    {
        return $this->hasMany(Article_content::class)->orderBy('ordered', 'desc');
    }

}
