<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category1 extends Model
{
    public function children($value = '')
    {
        return $this->hasMany('App\Category2');
    }
}
