<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category2 extends Model
{
    public function category1($value = '')
    {
        return $this->belongsTo('App\Category1');
    }
    public function children($value = '')
    {
        return $this->hasMany('App\Category3');
    }
}
