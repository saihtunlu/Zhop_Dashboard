<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fav extends Model
{
    public function product($value = '')
    {
        return $this->belongsTo('App\product');
    }
    public function user($value = '')
    {
        return $this->belongsTo('App\User');
    }
}
