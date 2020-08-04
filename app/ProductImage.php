<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    public function product($value = '')
    {
        return $this->belongsTo('App\Product');
    }
}
