<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    public function order($value = '')
    {
        return $this->belongsTo('App\Order');
    }
    public function variation($value = '')
    {
        return $this->belongsTo('App\Variation');
    }
    public function product($value = '')
    {
        return $this->belongsTo('App\Product');
    }
}
