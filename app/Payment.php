<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function banks($value = '')
    {
        return $this->hasMany('App\Bank');
    }
    public function restrictions($value = '')
    {
        return $this->hasMany('App\Restriction');
    }
}
