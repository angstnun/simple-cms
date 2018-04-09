<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\User;
use App\CategoryArticle;
use Illuminate\Support\Collection;
use App\PageArticle;

class Article extends Model
{
    protected $fillable = ['category_id', 'content', 'description', 'published_at', 'title'];
    protected $table = 'article';

    //Carbon variables

    protected $dates = ['published_at'];
    public $user;
    public $categories;

    public static function boot()
    {
    	parent::boot();
		self::retrieved(function (Model $model)
        {
            $model->user = User::find($model->user_id);
            $model->categories = $model->categories();
        });
        self::deleting(function (Article $article) {
            $pages_article = PageArticle::where('article_id', $article->id)->get();
            $categories_article = CategoryArticle::where('article_id', $article->id)->get();
            for($i=0;$i<count($pages_article);$i++){ $pages_article[$i]->delete(); };
            for($i=0;$i<count($categories_article);$i++){ $categories_article[$i]->delete(); };
        });
    }

    public function categories()
    {
    	$category_article = CategoryArticle::where('article_id', $this->id)->get();
    	$categories = new Collection();
    	for($i=0;$i<count($category_article);$i++) $categories->push($category_article[$i]->category());
    	return $categories;
    }

    public static function search(Array $args)
    {
        if(count($args['cols']) == 1)
        {
            $articles_found = DB::table('article')->whereRaw($args['cols'][0] . ' ' . $args['operator'] . ' ' . $args['pattern'])->get();
            if($articles_found->first())
            {
                $article_collection = new Collection();
                for($i=0;$i<count($articles_found);$i++)
                {
                    $article_collection->push(Article::find($articles_found[$i]->id));
                }
                return $article_collection;
            }
            return null;
        }
    }
}
