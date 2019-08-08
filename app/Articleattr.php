<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articleattr extends Model
{

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
