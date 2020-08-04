<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public function user($value = '')
    {
        return $this->belongsTo('App\User');
    }
}
