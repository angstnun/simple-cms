<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Page;
use App\Category;

class PageCategory extends Model
{
    protected $table = 'pages_categories';
    protected $primaryKey = 'page_id';
    public $timestamps = false;

    public function page()
    {
    	return Page::find($this->page_id);
    }

    public function category()
    {
    	$category = Category::find($this->category_id);
    	$category->setOrder($this->order());
    	return $category;
    }

    private function order()
    {
    	return $this->is_ordered_asc == true ? 'ASC' : 'DESC';
    }
}
