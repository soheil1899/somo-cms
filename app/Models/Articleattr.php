<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Articleattr extends Model
{

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
