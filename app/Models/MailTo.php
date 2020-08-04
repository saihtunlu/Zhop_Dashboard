<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailTo extends Model
{
    public function mail($value = '')
    {
        return $this->belongsTo('App\EMail', 'mail_id');
    }
    public function user($value = '')
    {
        return $this->belongsTo('App\User');
    }
}
