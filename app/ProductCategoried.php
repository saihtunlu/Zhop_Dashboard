<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategoried extends Model
{
    public function product($value = '')
    {
        return $this->belongsTo('App\Product');
    }
    public function category1($value = '')
    {
        return $this->belongsTo('App\Category1');
    }
    public function category2($value = '')
    {
        return $this->belongsTo('App\Category2');
    }
    public function category3($value = '')
    {
        return $this->belongsTo('App\Category3');
    }
}
