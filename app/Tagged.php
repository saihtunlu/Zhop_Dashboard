<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tagged extends Model
{
    public function product($value = '')
    {
        return $this->belongsTo('App\Product');
    }
    public function tag($value = '')
    {
        return $this->belongsTo('App\Tag');
    }
}
