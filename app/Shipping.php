<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    public function cities($value = '')
    {
        return $this->hasMany('App\City');
    }
    public function methods($value = '')
    {
        return $this->hasMany('App\Method');
    }
}
