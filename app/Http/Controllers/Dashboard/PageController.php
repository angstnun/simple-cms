<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request as Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB as DB;
use Exception;
use App\Page;
use App\Homepage;
use App\PagePage;
use App\PageCategory;
use App\PageArticle;
use App\Slug;

class PageController extends DashboardController
{

	public function index()
	{
		$pages = new Page();
		return view('dashboard.pages', ['pages' => $pages->paginatedPages(10)]);
	}

	public function getPagesNames()
	{
		return DB::table('pages')->select('id', 'title')->get();
	}

	public function showPageCreator(Request $request)
	{
		return view('dashboard.page-create', ['info' => $request->input('info')]);
	}

	public function showPageEditor(Request $request)
	{
		$mainPage = Page::find($request->input('page-id'));
		$isHomepage = Homepage::first();
		$isHomepage = $isHomepage->isHomepage($request->input('page-id'));
		$pages = $mainPage->pages();
		$articles = $mainPage->articles();

		$categories = DB::table('pages_categories')
			->join('categories', 'pages_categories.category_id', '=', 'categories.id')
			->where('pages_categories.page_id', '=', $request->input('page-id'))
			->select('categories.id', 'categories.title', 'pages_categories.category_display_type_id', 'pages_categories.is_in_lnavbar', 'pages_categories.is_in_rnavbar', 'pages_categories.is_in_body', 'pages_categories.is_ordered_asc')
			->get();

		return view('dashboard.page-edit', ['parentPage' => $mainPage, 'isHomepage' => $isHomepage, 'components' => ['pages' => $pages, 'articles' => $articles, 'categories' => $categories], 'info' => null]);
	}

	public function editPage(Request $request)
	{
		try
		{
			$page = Page::find($request->input('page-id'));
			$page->title = $request->input('page-title');
			$page->description = $request->input('page-description');
			$page->isDisplayed = $request->input('isDisplayed') ? true : false;
			$page->save();
			$this->setHomepage($request);
			$this->updatePageRelationships($request);
			$this->deletePageRelationships($request);
			$this->deleteCategoryRelationships($request);
			$this->deleteArticleRelationships($request);
			$this->updatePageCategoryDisplayStyle($request);
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
		return redirect('edit-page?page-id=' . $request->input('page-id'));
	}

	private function setHomepage(Request $request)
	{
		$isHomepageInput = $request->input('isHomepage') ? true : false;
		$homepage = Homepage::first();

		if($homepage->isHomepage($request->input('page-id')) and !$isHomepageInput)
		{
			$homepage->page_id = null;
			$homepage->save();
		}
		else
		{
			if($isHomepageInput)
			{
				$homepage->page_id = $request->input('page-id');
				$homepage->save();
			}
		}
	}

	public function removePage($page_id, $child_id)
	{
		return PagePage::where('page_id_0', $page_id)
			->where('page_id_1', $child_id)
			->first()->delete();
	}

	public function removeCategory($page_id, $category_id)
	{
		return PageCategory::where('page_id', $page_id)
			->where('category_id', $category_id)
			->first()->delete();
	}

	public function removeArticle($page_id, $article_id)
	{
		return PageArticle::where('page_id', $page_id)
			->where('article_id', $article_id)
			->first()->delete();
	}

	public function newPage(Request $request)
	{
		try
		{
			$this->createNewPage($request);
		}
		catch(Exception $e)
		{
			return redirect()->action('Dashboard\PageController@showPageCreator', ['info' => $e->getMessage()]);
		}
		return redirect()->action('Dashboard\PageController@index');
	}

	private function createNewPage(Request $request)
	{
		if(!$request->input('page-title')) throw new Exception('You ought to give this page a name.');
		$page = new Page();
		$slug = new Slug();
		$page->title = $request->input('page-title');
		$page->description = $request->input('page-description');
		$page->isDisplayed = $request->input('is-displayed') ? true : false;
		$page->slug = $slug->generateSlug(['title' => $page->title]);
		$page->save();
		$this->createPageRelationships($request, $page->id);
	}

	private function deletePageRelationships(Request $request)
	{
		if(!$request->input('page-list'))
		{
			DB::table('pages_pages')->where([
				['page_id_0', '=', $request->input('page-id')]
			])->delete();
		}
		else
		{
			$pages = DB::table('pages_pages')->where('page_id_0', $request->input('page-id'))->get();
			if($pages->first())
			{
				foreach($pages as $page)
				{
					if(!$this->isInComponentInputList($page->page_id_1, $request->input('page-list'))) $this->removePage($request->input('page-id'), $page->page_id_1);
				}
			}
		}
	}

	private function deleteCategoryRelationships(Request $request)
	{
		if(!$request->input('category-list'))
		{
			DB::table('pages_categories')->where([
				['page_id', '=', $request->input('page-id')]
			])->delete();
		}
		else
		{
			$categories = DB::table('pages_categories')->where('page_id', $request->input('page-id'))->get();
			if($categories->first())
			{
				foreach($categories as $category)
				{
					if(!$this->isInComponentInputList($category->category_id, $request->input('category-list'))) $this->removeCategory($request->input('page-id'), $category->category_id);
				}
			}
		}
	}

	private function deleteArticleRelationships(Request $request)
	{
		if(!$request->input('article-list'))
		{
			DB::table('pages_article')->where([
				['page_id', '=', $request->input('page-id')]
			])->delete();
		}
		else
		{
			$articles = DB::table('pages_article')->where('page_id', $request->input('page-id'))->get();
			if($articles->first())
			{
				foreach($articles as $article)
				{
					if(!$this->isInComponentInputList($article->article_id, $request->input('article-list'))) $this->removeArticle($request->input('page-id'), $article->article_id);
				}
			}
		} 
	}

	private function isInComponentInputList($component_id, Array $list)
	{
		for($i=0;$i<count($list);$i++) if($component_id == $list[$i]['id']) return true;
			
		return false;
	}

	private function updatePageArticlePreferences(Request $request)
	{
		if($request->input('articles-preferences'))
		{
			$page_preferences = DB::table('pages_article_preferences')->where('page_id', $request->input('page-id'))->first();
			if($page_preferences && $page_preferences->is_ordered_asc != $request->input('articles-preferences')['order'])
			{	
				DB::table('pages_article_preferences')->where('page_id', $request->input('page-id'))->update(['is_ordered_asc' => $request->input('articles-preferences')['order']]);
			}
			else
			{
				DB::table('pages_article_preferences')->insert(['page_id' => $request->input('page-id'), 'is_ordered_asc', $request->input('articles-preferences')['order']]);
			}
		}
	}

	private function updatePageCategoryDisplayStyle(Request $request)
	{
		if($request->input('category-list'))
		{
			for($i=0;$i<count($request->input('category-list'));$i++)
			{
				$page_category = DB::table('pages_categories')->where([
					['page_id', '=', $request->input('page-id')],
					['category_id', '=', $request->input('category-list')[$i]['id']]
				])->first();

				if($page_category->category_display_type_id != $request->input('category-list')[$i]['displayStyle']) DB::table('pages_categories')->where([
					['page_id', '=', $request->input('page-id')],
					['category_id', '=', $request->input('category-list')[$i]['id']]
				])->update(['category_display_type_id' => $request->input('category-list')[$i]['displayStyle']]);

				$is_in_lnavbar = array_key_exists('is_in_lnavbar', $request->input('category-list')[$i]) ? true : false;
				$is_in_rnavbar = array_key_exists('is_in_rnavbar', $request->input('category-list')[$i]) ? true : false;
				$is_in_body = array_key_exists('is_in_body', $request->input('category-list')[$i]) ? true : false;
				$is_ordered_asc = $request->input('category-list')[$i]['is_ordered_asc'] == 'true' ? true : false;

				if($page_category->is_in_lnavbar != $is_in_lnavbar) DB::table('pages_categories')->where([
					['page_id', '=', $request->input('page-id')],
					['category_id', '=', $request->input('category-list')[$i]['id']]
				])->update(['is_in_lnavbar' => $is_in_lnavbar]);

				if($page_category->is_in_rnavbar != $is_in_rnavbar) DB::table('pages_categories')->where([
					['page_id', '=', $request->input('page-id')],
					['category_id', '=', $request->input('category-list')[$i]['id']]
				])->update(['is_in_rnavbar' => $is_in_rnavbar]);

				if($page_category->is_in_body != $is_in_body) DB::table('pages_categories')->where([
					['page_id', '=', $request->input('page-id')],
					['category_id', '=', $request->input('category-list')[$i]['id']]
				])->update(['is_in_body' => $is_in_body]);

				if($page_category->is_ordered_asc != $is_ordered_asc) DB::table('pages_categories')->
					where([
					['page_id', '=', $request->input('page-id')],
					['category_id', '=', $request->input('category-list')[$i]['id']]
				])->update(['is_ordered_asc' => $is_ordered_asc]);
			}
		}
	}

	private function updatePageRelationships(Request $request)
	{
		if($request->input('page-list'))
		{
			foreach($request->input('page-list') as $page)
			{
				if(!DB::table('pages_pages')->where([
					['page_id_0', '=', $request->input('page-id')], 
					['page_id_1', '=', $page['id']]
				])->first())
				{
					$this->createPageToPageRelationship($request->input('page-id'), [['id' => $page['id']]]);
				}
			}
		}
		if($request->input('category-list'))
		{
			foreach($request->input('category-list') as $category)
			{
				if(!DB::table('pages_categories')->where([
					['page_id', '=', $request->input('page-id')],
					['category_id', '=', $category['id']]
				])->first())
				{
					$this->createPageToCategoryRelationship($request->input('page-id'), [$category]);
				}
			}
		}
		if($request->input('article-list'))
		{
			foreach($request->input('article-list') as $article)
			{
				if(!DB::table('pages_article')->where([
					['page_id', '=', $request->input('page-id')],
					['article_id', '=', $article['id']]
				])->first())
				{
					$this->createPageToArticleRelationship($request->input('page-id'), [['id' => $article['id']]]);
				}
			}
		}
	}

	private function createPageRelationships(Request $request, $page_id)
	{
		$this->createPageToPageRelationship($page_id, $request->input('page-list'));
		$this->createPageToCategoryRelationship($page_id, $request->input('category-list'));
		$this->createPageToArticleRelationship($page_id, $request->input('article-list'));
		$this->setHomepage($request);
	}

	private function updatePageToPageRelationship($parent_page_id, $pages)
	{
		if($pages && $parent_page_id)
		{
			for($i=0;$i<count($pages);$i)
			{
				$page_page = PagePage::find($parent_page_id);
				$page_page->page_id_1 = $pages[$i]['id'];
				$page_page->save();
			}
		}
	}

	private function createPageToPageRelationship($parent_page_id, $pages)
	{
		if($pages && $parent_page_id) 
		{
			for($i=0;$i<count($pages);$i++)
			{
				$page_page = new PagePage();
				$page_page->page_id_0 = $parent_page_id;
				$page_page->page_id_1 = $pages[$i]['id'];
				$page_page->save();
			} 
		}
	}

	private function updatePageToCategoryRelationship($page_id, $categories)
	{
		if($categories && $page_id)
		{
			for($i=0;$i<count($categories);$i++)
			{
				$page_category = PageCategory::find($page_id);
				$page_category->category_id = $categories[$i]['id'];
				$page_category->save();
			}
		}
	}

	private function createPageToCategoryRelationship($page_id, $categories)
	{
		if($categories && $page_id)
		{
			for($i=0;$i<count($categories);$i++)
			{
				$page_category = new PageCategory();
				$page_category->page_id = $page_id;
				$page_category->category_id = $categories[$i]['id'];
				$page_category->save();
			}
		}
	}

	private function createPageToArticleRelationship($page_id, $articles)
	{
		if($articles && $page_id)
		{
			for($i=0;$i<count($articles);$i++)
			{
				$page_article = new PageArticle();
				$page_article->page_id = $page_id;
				$page_article->article_id = $articles[$i]['id'];
				$page_article->save();
			}
		}
	}

	private function updatePageToArticleRelationship($page_id, $articles)
	{
		if($articles && $page_id)
		{
			for($i=0;$i<count($articles);$i++)
			{
				$page_article = PageArticle::find($page_id);
				$page_article->article_id = $articles[$i]['id'];
				$page_article->save();
			}
		}
	}

	public function deletePage(Request $request)
	{
		try
		{
			$page = Page::find($request->input('page-id'));
			$page->delete();
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
		return redirect()->action('Dashboard\PageController@index');
	}

	public function searchPage(Request $request)
	{
		try
		{
			$pages = Page::where('title', 'LIKE', '%' . $request->input('search-text') . '%')->paginate(10);
		}
		catch(Exception $e)
		{
			return redirect()->action('Dashboard\PageController@index', ['info' => $e->getMessage()]);
		}
		return view('dashboard.pages', ['pages' => $pages]);
	}
}

