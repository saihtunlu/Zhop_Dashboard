<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CalendarEvent extends Model
{
    use SoftDeletes;
    public function category($value = '')
    {
        return $this->belongsTo('App\CalendarCategory', 'calendar_category_id');
    }
    public function user($value = '')
    {
        return $this->belongsTo('App\User');
    }
}
