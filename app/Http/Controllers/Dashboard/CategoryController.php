<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Category;
use App\CategoryArticle;
use App\Slug;
use Exception;

class CategoryController extends DashboardController
{

	public function index(Request $request)
	{
		$categories = DB::table('categories')
			->select('id', 'title', 'description', 'color')
			->orderBy('id', 'desc')
			->paginate(10);            

		return view('dashboard.categories', ['categories' => $categories]); 
	}

	public function showCategoryCreator(Request $request)
	{
		return view('dashboard.category-create', ['info' => $request->input('info')]);
	}

	public function showCategoryEditor(Request $request)
	{
		$category = Category::find($request->input('category-id'));

		$articles = $category->articles();

		$articleList = DB::table('article')
			->select('id', 'title')
			->get();

		return view('dashboard.category-edit', ['category' => $category, 
			'components' => ['articles' => $articles, 'articleList' => $articleList], 'info' => null
		]);
        return dd($articles);
	}

	public function createCategory(Request $request)
    {
    	try {
            $this->newCategory($request);
    	}
    	catch(Exception $e) {
    		return redirect()->action('Dashboard\CategoryController@showCategoryCreator', ['info' => $e->getMessage()]);
    	}
    	return redirect()->action('Dashboard\CategoryController@index');
    }

    private function newCategory(Request $request)
    {
        if(!$request->input('category-title')) throw new Exception('You ought to give this category a name.');
        $category = new Category();
        $slug = new Slug();
        $category->title = $request->input('category-title');
        $category->description = $request->input('category-description');
        $category->color = $request->input('color-hex');
        $category->slug = $slug->generateSlug(['title' => $category->title]);
        $category->save();
        if($request->input('article-list'))
        {    
            $this->createCategoryRelationships($category->id, $request->input('article-list'));
        }
    }

    public function editCategory(Request $request)
    {
    	try
    	{
    		$category =  Category::find($request->input('category-id'));
    		$category->title = $request->input('category-title');
    		$category->description = $request->input('category-description');
    		$category->color = $request->input('color-hex');
    		$category->save();
    		$this->updateCategoryRelationships($request);
    		$this->deleteArticleRelationships($request);
    	}
    	catch(Exception $e)
    	{
    		return $e->getMessage();
    	}
		return $this->showCategoryEditor($request);
        // return dd([$request->input('article-list'), CategoryArticle::where('category_id', $request->input('category-id'))->get() ]);
    }

    private function updateCategoryRelationships(Request $request)
    {
    	if($request->input('article-list'))
    	{
            for($i=0;$i<count($request->input('article-list'));$i++) {
                if(!DB::table('categories_article')->where([
                    ['category_id', '=', $request->input('category-id')],
                    ['article_id', '=', $request->input('article-list')[$i]['id']]
                ])->first()) {
                    $this->createCategoryRelationships($request->input('category-id'), [$request->input('article-list')[$i]]);
                }
            }
    	}
    }

    /* Check whether the category has any articles, delete them if not;
     * Otherwise check for the articles in the relationship that aren't part of the article-list and delete them; If category-article[n] not in article-list(list of articles to be updated to) , delete category-article[n].
    */
    private function deleteArticleRelationships(Request $request)
    {
        $debug = array();
    	if(!$request->input('article-list')) {
    		DB::table('categories_article')->where([
    			['category_id', '=', $request->input('category-id')]
    		])->delete();
    	}
    	else {
            $article_list = $request->input('article-list');
            $category_articles = CategoryArticle::where('category_id', $request->input('category-id'))->get();

            if($category_articles->first()) {
                for($i=0;$i<count($category_articles);$i++) {
                    $found = false;
                    for($n=0;$n<count($article_list);$n++) {
                        if($category_articles[$i]->article_id == $article_list[$n]['id'] ) {
                            $found = true;
                            break;
                        }
                    }
                    if(!$found) {
                        $this->removeArticle($request->input('category-id'), $category_articles[$i]->article_id);
                    }
                }
            }
    	}
    }

    public function removeArticle($category_id, $child_article_id)
	{
		DB::table('categories_article')->where([
			['category_id', '=', $category_id],
			['article_id', '=', $child_article_id]
		])->delete();
	}

    public function deleteCategory(Request $request)
    {
		try
		{
            $category = Category::find($request->input('category-id'));
            $category->delete();
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
		return redirect()->action('Dashboard\CategoryController@index');
    }

    public function createCategoryRelationships($category_id, $article_list)
    {
        for($i=0;$i<count($article_list);$i++) {
            $newCategoryArticle = new CategoryArticle();
            $newCategoryArticle->category_id = $category_id;
            $newCategoryArticle->article_id = $article_list[$i]['id'];
            $newCategoryArticle->save();
        }
    }
    
	public function getCategoryNames()
	{
		return DB::table('categories')->select('id', 'title')->get();
	}

    public function searchCategory(Request $request)
    {
        try
        {
            $categories = Category::where('title', 'LIKE', '%' . $request->input('search-text') . '%')->paginate(10);
        }
        catch(Exception $e)
        {
            return redirect()->action('Dashboard\CategoryController@index', ['info' => $e->getMessage()]);
        }
        return view('dashboard.categories', ['categories' => $categories]);
    }
    
}
