<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

    protected $fillable = [
        'image', 'title', 'link', 'subtext', 'slider_id'
    ];

    public function sliders()
    {
        return $this->belongsTo(Slider::class);
    }
}
