<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Article;

class PageArticle extends Model
{
    protected $table = 'pages_article';
    protected $primaryKey = 'page_id';
    public $timestamps = false;

    public function article()
    {
    	return Article::find($this->article_id);
    }
}
