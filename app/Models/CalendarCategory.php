<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarCategory extends Model
{
    public function event($value = '')
    {
        return $this->hasMany('App\CalendarEvent');
    }
    public function user($value = '')
    {
        return $this->belongsTo('App\User');
    }
}
