<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fav extends Model
{
    public function product($value = '')
    {
        return $this->belongsTo('App\Product');
    }
    public function user($value = '')
    {
        return $this->belongsTo('App\User');
    }
}
