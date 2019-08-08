<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subattribute_value extends Model
{
    




    public function subattribute()
    {
        return $this->belongsTo(Subattribute::class);
    }
}
