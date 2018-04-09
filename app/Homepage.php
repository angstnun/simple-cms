<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Page;

class Homepage extends Model
{
	protected $table = 'home_page';
	public $timestamps = false;

	public function isHomepage($pageId)
	{
		return $this->page_id == $pageId ? true : false;
	}

    public function page()
    {
    	$home_page = DB::table('home_page')->first();
    	if($home_page->page_id) return Page::find($home_page->page_id);
		return null;
    }
}
