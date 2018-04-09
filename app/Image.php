<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public $fillable = ['filename, description, title'];
    public $timestamps = false;
}
