<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu_group extends Model
{
    public function submenus()
    {
        return $this->hasMany(Menu::class);
    }
}
