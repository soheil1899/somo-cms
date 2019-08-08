<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = [
        'name', 'hexcode',
    ];


    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
