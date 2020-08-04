<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function tagged($value = '')
    {
        return $this->hasMany('App\Tagged');
    }
}
