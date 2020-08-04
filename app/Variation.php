<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    public function product($value = '')
    {
        return $this->belongsTo('App\Product');
    }
    public function attri1($value = '')
    {
        return $this->belongsTo('App\AttributeDetail', 'attribute1_id');
    }
    public function Attri2($value = '')
    {
        return $this->belongsTo('App\AttributeDetail', 'attribute2_id');
    }
}
