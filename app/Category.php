<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\CategoryArticle;
use App\PageCategory;

class Category extends Model
{
    protected $fillable = ['color', 'description', 'title'];

    private $order = 'ASC';
    public $timestamps = false;

    public static function boot() {
        parent::boot();
        self::deleting(function (Category $category) {
            $category_articles = CategoryArticle::where('category_id', $category->id)->get();
            $pages_category = PageCategory::where('category_id', $category->id)->get();
            for($i=0;$i<count($category_articles);$i++){ $category_articles[$i]->delete(); };
            for($i=0;$i<count($pages_category);$i++){ $pages_category[$i]->delete(); };
        });
    }

    /**
    *   Order attribute setter
    *   @param String. $order. Must be a string with the values 'ASC' or 'DESC';
    */
    public function setOrder(String $order)
    {
        $this->order = $order;
    }

    /**
    *   Retrieve all the Category-Article relationship entities
    *   @return Collection. Includes all the articles belonging to this relationship, or none if it doesn't have any.
    */
    public function articles()
    {
        $category_article = CategoryArticle::where('category_id', $this->id)->get();
        
        $article_collection = new Collection();

        if($category_article->first()) for($i=0;$i<count($category_article);$i++) $article_collection->push($category_article[$i]->article());

        return $article_collection;
    }

    public static function search(Array $args)
    {
        if(count($args['cols']) == 1)
        {
            $categories_found = DB::table('categories')->whereRaw($args['cols'][0] . ' ' . $args['operator'] . ' ' . $args['pattern'])->get();
            if($categories_found->first())
            {
                $category_collection = new Collection();
                for($i=0;$i<count($categories_found);$i++)
                {
                    $category_collection->push(Category::find($categories_found[$i]->id));
                }
                return $category_collection;
            }
            return null;
        }
    }
}

