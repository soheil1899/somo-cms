<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subattribute extends Model
{





    public function attribute_values()
    {
        return $this->hasMany(Subattribute_value::class);
    }


    public function group_attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
