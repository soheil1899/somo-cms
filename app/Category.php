<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = [
        'name', 'description', 'last', 'parent_id'
    ];


    public function products()
    {
        return $this->hasMany(Product::class);
    }


    public function group_attributes()
    {
        return $this->belongsToMany(Attribute::class);
    }


    public function parent()
    {
        return $this->hasOne(Category::class,'id','parent_id');
    }
}
