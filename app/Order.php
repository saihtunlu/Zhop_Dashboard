<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function user($value = '')
    {
        return $this->belongsTo('App\User');
    }
    public function billAddress($value = '')
    {
        return $this->hasOne('App\BillAddress');
    }
    public function payment($value = '')
    {
        return $this->belongsTo('App\Payment');
    }
    public function detail($value = '')
    {
        return $this->hasMany('App\OrderDetail');
    }
}
