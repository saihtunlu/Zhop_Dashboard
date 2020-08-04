<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    public function categoried($value = '')
    {
        return $this->belongsTo('App\ProductCategoried');
    }
}
