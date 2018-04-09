<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //
    protected $fillable = ['analytics_id', 'disqus_shortname', 'email', 'facebook', 'logo', 'twitter'];
}
