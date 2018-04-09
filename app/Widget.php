<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Widget extends Model {
	
	protected $fillable = array('name', 'filename', 'author');
}