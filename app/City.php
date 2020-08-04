<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function shippings($value = '')
    {
        return $this->belongsTo('App\Shipping');
    }
}
