<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function contents()
    {
        return $this->belongsToMany(Article::class);
    }
}
