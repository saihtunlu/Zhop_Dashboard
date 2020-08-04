<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillAddress extends Model
{
    public function order($value = '')
    {
        return $this->belongsTo('App\Order');
    }
}
