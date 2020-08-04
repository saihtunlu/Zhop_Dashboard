<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category3 extends Model
{
    public function category2($value = '')
    {
        return $this->belongsTo('App\Category2');
    }
}
