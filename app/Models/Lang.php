<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lang extends Model
{

    public function articlegroups()
    {
        return $this->hasMany(Article_group::class);
    }

}
