<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Article;
use App\Category;

class CategoryArticle extends Model
{
    protected $table = 'categories_article';
    protected $primaryKey = 'category_id';
    protected $fillable = ['category_id', 'article_id'];
    public $timestamps = false;

    public function article()
    {
    	return Article::find($this->article_id);
    }

    public function category()
    {
    	return Category::find($this->category_id);
    }
}
