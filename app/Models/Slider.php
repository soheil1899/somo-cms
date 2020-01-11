<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'title',
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
