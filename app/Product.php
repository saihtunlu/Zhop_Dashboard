<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    public function brand($value = '')
    {
        return $this->belongsTo('App\Brand');
    }

    public function categories($value = '')
    {
        return $this->hasMany('App\ProductCategoried');
    }
    public function images($value = '')
    {
        return $this->hasMany('App\ProductImage');
    }
    public function attributes($value = '')
    {
        return $this->hasMany('App\Attribute');
    }
    public function tags($value = '')
    {
        return $this->hasMany('App\Tagged');
    }
    public function variations($value = '')
    {
        return $this->hasMany('App\Variation');
    }
}
