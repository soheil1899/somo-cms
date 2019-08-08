<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class);
    }

    public function guarantees()
    {
        return $this->belongsToMany(Guarantee::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function gallery()
    {
        return $this->hasMany(Gallery::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }


    
}
