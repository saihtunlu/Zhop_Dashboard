<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restriction extends Model
{
    public function cities($value = '')
    {
        return $this->hasMany('App\RestrictedCity');
    }
    public function payment($value = '')
    {
        return $this->belongsTo('App\Payment');
    }
    public function shipping($value = '')
    {
        return $this->belongsTo('App\Shipping');
    }
}
