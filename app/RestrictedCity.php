<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RestrictedCity extends Model
{
    public function restriction($value = '')
    {
        return $this->belongsTo('App\Restriction');
    }
}
