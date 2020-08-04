<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    public function details($value = '')
    {
        return $this->hasMany('App\AttributeDetail');
    }
    public function product($value = '')
    {
        return $this->belongsTo('App\Product');
    }
}
