<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\ImageController;
use Illuminate\Support\Facades\DB;
use App\Exceptions\AppExceptions;
use App\Article;
use App\Slug;

class ArticleController extends DashboardController
{
    public function index()
    {
    	$articles = DB::table('categories_article')
    		->join('categories', 'categories_article.category_id', '=', 'categories.id')
            ->rightJoin('article', 'categories_article.article_id', '=', 'article.id')
    		->select('article.id', 'article.title', 'article.description', 'categories.title as category_title')
    		->orderBy('category_title')
    		->paginate(10);
            
    	return view('dashboard.articles', ['articles' => $articles]);
    }

    public function showArticleEditor(Request $request)
    {
        $article = DB::table('categories_article')
            ->join('categories', 'categories_article.category_id', '=', 'categories.id')
            ->rightJoin('article', 'categories_article.article_id', '=', 'article.id')
            ->where('article.id', '=', $request->input('article-id'))
            ->select('article.id', 'article.title', 'article.description', 'article.content', 'categories.id as category_id', 'categories.title as category_title')
            ->first();

        $image_list = json_encode(ImageController::getImageList());

        if($article) return view('dashboard.article-editor', ['article' => $article, 'image_list' => $image_list, 'info' => null]);

        return abort(404);
    }

    public function showArticleCreator()
    {
        $image_list = json_encode(ImageController::getImageList());
        return view('dashboard.article-create', ['image_list' => $image_list, 'info' => null]);
    }

    public function editArticle(Request $request)
    {
        try
        {
            $article = Article::find($request->input('article-id'));
            $article->title = $request->input('article-title');
            $article->description = $request->input('article-description');
            $article->content = $request->input('textarea');
            $article->save();
            $this->updateImages($request);
        }
        catch(Exception $e)
        {
            return $e->getMessage();
        }
        return $this->showArticleEditor($request);
    }

    private function updateImages(Request $request)
    {
        $dom = new \DOMDocument();
        $dom->loadHTML($request->input('textarea'));
        $imgTags = $dom->getElementsByTagName('img');
        if($imgTags->length > 0) {
            for($i=0;$i<count($imgTags);$i++) {
                $filename = ImageController::getImageFilename($imgTags[$i]->getAttribute('src'));
                DB::table('images')->where('filename', $filename)->update(
                    ['title' => $imgTags[$i]->getAttribute('title'), 
                    'description' => $imgTags[$i]->getAttribute('alt')]
                );
            }
        }
    }

    private function checkIfModified($result, $request)
    {
        if($result->title != $request->input('article-title') || $result->description != $request->input('article-description') || $result->content != $request->input('textarea'))
        {
            return true;
        }
        return false;
    }

    public function createArticle(Request $request)
    {
        $article = new Article();
        $slug = new Slug();
        $article->title = $request->input('article-title');
        $article->description = $request->input('article-description');
        $article->content = $request->input('textarea');
        $article->published_at = date('Y-m-d H:i:s');
        $article->slug = $slug->generateSlug(['title' => $article->title]);
        try
        {
            $article->save();
        }
        catch(Exception $e)
        {
            return $e->getMessage();
        }
        return redirect()->action('Dashboard\ArticleController@index');
    }

    public function deleteArticle(Request $request)
    {
        try
        {
            Article::find($request->input('article-id'))->delete();
        }
        catch(Exception $e)
        {
            return $e->getMessage();
        }
        return redirect()->action('Dashboard\ArticleController@index');
    }

    public function getArticleNames()
    {
        return DB::table('article')->select('id', 'title')->get();
    }

    public function searchArticle(Request $request)
    {
        try
        {
            $articles = Article::where('title', 'LIKE', '%' . $request->input('search-text') . '%')->paginate(10);
        }
        catch(Exception $e)
        {
            return redirect()->action('Dashboard\ArticleController@index', ['info' => $e->getMessage()]);
        }
        return view('dashboard.articles', ['articles' => $articles]);
    }
}
