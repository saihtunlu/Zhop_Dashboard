<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionProduct extends Model
{
    protected $fillable = ['create', 'update', 'read', 'delete'];

    public function users($value = '')
    {
        return $this->belongsTo('App\user');
    }
}
