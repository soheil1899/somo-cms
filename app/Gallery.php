<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{

    protected $fillable = [
        'product_id', 'article_id', 'image', 'slider'
    ];

    public function content()
    {
        return $this->belongsTo(Article_content::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
