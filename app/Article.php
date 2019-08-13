<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{


    public function keywords()
    {
        return $this->hasMany(Keyword::class);
    }


    public function article_group()
    {
        return $this->belongsTo(Article_group::class);
    }


    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }


    public function contents()
    {
        return $this->hasMany(Article_content::class)->orderBy('ordered', 'asc');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pdf()
    {
        return $this->hasOne(Pdf::class);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    public function attributes()
    {
        return $this->hasMany(Articleattr::class);
    }


}
