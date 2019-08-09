<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article_content extends Model
{
    protected $fillable = [
        'ordered', 'article_id', 'article_type_id',
    ];


    public function article()
    {
        return $this->belongsTo(Article::class);
    }


    public function article_type()
    {
        return $this->belongsTo(Article_type::class);
    }




}
