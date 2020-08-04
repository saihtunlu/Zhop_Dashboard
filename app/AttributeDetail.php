<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributeDetail extends Model
{
    public function attribute($value = '')
    {
        return $this->belongsTo('App\Attribute');
    }
}
