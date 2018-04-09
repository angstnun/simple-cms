<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Page;

class PagePage extends Model
{
    protected $table = 'pages_pages';
    protected $primaryKey = 'page_id_0';
    public $timestamps = false;

    public function page()
    {
    	return Page::find($this->page_id_1);
    }
}
