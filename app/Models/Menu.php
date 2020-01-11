<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public function menugroup()
    {
        return $this->belongsTo(Menu_group::class);
    }
    public function articlegroup()
    {
        return $this->hasOne(Article_group::class);
    }
    public function article()
    {
        return $this->hasOne(Article::class);
    }
}
