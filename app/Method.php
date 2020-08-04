<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Method extends Model
{
    public function shippings($value = '')
    {
        return $this->belongsTo('App\Shipping');
    }
}
