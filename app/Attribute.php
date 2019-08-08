<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{

    protected $fillable = [
        'title', 'description',
    ];


    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }


    public function subattributes()
    {
        return $this->hasMany(Subattribute::class);
    }
}
