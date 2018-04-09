<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Acid\HomeMaker;
use App\Page;
use App\Category;
use App\Article;
use App\Homepage;
use App\SearchResultPage;
use App\Plugins\DynamicList\DynamicList as DynamicList;
use Illuminate\Database\QueryException;

class HomeController extends Controller
{
    private $builder;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->builder = new HomeMaker();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $home_page = new Homepage();
        $home_page = $home_page->page();
        $defaultPage = new Page();

        if($home_page)
        {
            $this->preparePage($home_page);
            $home_page->setSizes();

            return view('home', ['data' => [
                        'navbar_items' => $this->getIndexes([]),
                        'pageTitle' => $home_page->title,
                        'body' => $home_page->getBody(),
                        'left_bar' => $home_page->getLeftbar(),
                        'right_bar' => $home_page->getRightbar(),
                        'footer' => $home_page->getFooter()
                    ]]);
        }
        return view('home', ['data' => [
                    'navbar_items' => $this->getIndexes([]),
                    'pageTitle' => 'No home',
                    'body' => null,
                    'left_bar' => null,
                    'right_bar' => null,
                    'footer' => $defaultPage->getFooter()
                ]]);
    }

    public function getResource($slug)
    {
        if(Page::where('slug', $slug)->first())
        {
            return $this->showPage(Page::where('slug', $slug)->first());
        } 
        elseif(Category::where('slug', $slug)->first())
        {
            $container_page = new Page();
            $container_page->title = 'Categories';
            return $this->returnPageView($this->assembleCategoriesInPage(['category' => Category::where('slug', $slug)->first(), 'page' => $container_page, 'is_in_body' => true, 'is_in_lnavbar' => false, 'is_in_rnavbar' => false, 'category_display_type' => 1]));
        }
        elseif(Article::where('slug', $slug)->first())
        {
            $container_page = new Page();
            $container_page->title = 'Articles';
            $article_collection = new Collection();
            $article_collection->push(Article::where('slug', $slug)->first());
            return $this->returnPageView($this->assembleArticlesInPage(
                ['page' => $container_page,
                 'articles' => $article_collection,
             ]));
        }
        return abort(404);
    }

    /**
    *   Retrieve the selected page and display it.
    *   @param String $page The url of the page you want to access
    *   @return View The selected page
    */
    public function showPage($page)
    {
        $this->preparePage($page);
        $page->setSizes();
        return $this->returnPageView($page);
    }

    private function returnPageView(Page $page)
    {
            return view('home', ['data' => [
            'navbar_items' => $this->getIndexes(['selected_page' => $page->id]),
            'pageTitle' => $page->title,
            'body' => $page->getBody(),
            'left_bar' => $page->getLeftbar(),
            'right_bar' => $page->getRightbar(),
            'footer' => $page->getFooter()
        ]]);
    }

    /**
    *   Finishes retrieving a page's relationships, with its article's contents, ordered categories...
    *
    *   @param Collection $components A page collection, with articles' id, categories' id.
    *   @return  Array Every component's relationship and content organized in a root-children fashion. One page can have many pages and categories, categories only have articles.
    */
    private function preparePage($page)
    {
        $this->prepareArticles($page);
        $this->prepareCategories($page);
    }

    /**
    *   Places categories in a page, as specified in $args
    *   @param Array. $args. Needs 'page', 'category', 'is_in_body', 'is_in_lnavbar', 'is_in_rnavbar', 'category_display_type' keys.
    *   @return Page
    */
    public function assembleCategoriesInPage(Array $args)
    {
        $category_articles = $args['category']->articles();
        if($category_articles)
        {
            if($args['is_in_body'])
            {
                $category_html = null;
                $category_html = $category_html . $this->displayArticles([
                    'category_display_type' => $args['category_display_type'],
                    'category_title' => 'Category: ' . $args['category']->title,
                    'articles' => $category_articles
                ]);
                $args['page']->getBody()->setContent($args['page']->getBody()->getContent() . $category_html);
            }
            if($args['is_in_lnavbar'])
            {
                $category_html = null;
                $category_html = $category_html . $this->displayArticles([
                    'category_display_type' => 3,
                    'category_title' => $args['category']->title,
                    'articles' => $category_articles
                ]);
                $args['page']->getLeftbar()->setContent($args['page']->getLeftbar()->getContent() . $category_html);
            }
            if($args['is_in_rnavbar'])
            {
                $category_html = null;
                $category_html = $category_html . $this->displayArticles([
                    'category_display_type' => 3,
                    'category_title' => $args['category']->title,
                    'articles' => $category_articles
                ]);
                $args['page']->getRightbar()->setContent($args['page']->getRightbar()->getContent() . $category_html);
            }
        }
        return $args['page'];
    }

    /**
    *   Places all the categories and their articles inside a page's body, leftbar or rightbar and formats them.
    *   @param Page. $page. The page to be displayed.
    *   @return Page. Modified page, or not.
    */
    public function prepareCategories(Page $page)
    {
        $page_categories = $page->pageCategories();

        if($page_categories)
        {
            for($i=0;$i<count($page_categories);$i++)
            {
                $category_articles = $page_categories[$i]->category()->articles();
                $this->assembleCategoriesInPage([
                    'page' => $page,
                    'category' => $page_categories[$i]->category(),
                    'is_in_body' => $page_categories[$i]->is_in_body,
                    'is_in_lnavbar' => $page_categories[$i]->is_in_lnavbar,
                    'is_in_rnavbar' => $page_categories[$i]->is_in_rnavbar,
                    'category_display_type' => $page_categories[$i]->category_display_type_id
                ]);
            }
        }

        return $page;
    }

    /**
    *   Helper function to make article tables/lists/rows
    *   @param $args. Should contain the articles to be displayed, category's title and the header size.
    *   @return String. HTML string containing formatted 
    */
    private function displayArticles(Array $args)
    {
        switch($args['category_display_type'])
        {
            case 1:
                return $this->builder->buildCategoryHeader(['size' => array_key_exists('header_size', $args) ? $args['header_size'] : 2,
                 'title' => $args['category_title']
                ]) . $this->builder->buildArticleRows($args['articles']);
                break;
            case 2:
                return $this->builder->buildCategoryHeader(['size' => array_key_exists('header_size', $args) ? $args['header_size'] : 2,
                 'title' => $args['category_title']
                ]) . $this->builder->buildArticleTable($args['articles']);
                break;
            case 3:
                return $this->builder->buildCategoryHeader(['size' => array_key_exists('header_size', $args) ? $args['header_size'] : 3,
                 'title' => $args['category_title']
             ]) . $this->builder->buildArticleList(['articles' => $args['articles'], 'ul_classes' => '' ,'li_size' => '4']);
            default:
                return null;
                break;
        }
    }

    /**
    *   Formats and places a page's articles in its body.
    *   @param Page. $page.
    *   @return $page.
    */
    public function prepareArticles(Page $page)
    {
        $page_articles = $page->pageArticles();

        if($page_articles->first())
        {   $articles = new Collection();
            for($i=0;$i<count($page_articles);$i++)
            {
                $articles->push($page_articles[$i]->article());
            }
            $this->assembleArticlesInPage(['page' => $page, 'articles' => $articles]);
        }
        return $page;
    }

    public function assembleArticlesInPage(Array $args)
    {
        if($args['articles']) $args['page']->getBody()->setContent($args['page']->getBody()->getContent() . $this->builder->buildArticleRows($args['articles']));
        return $args['page'];
    }

    public function search(Request $request)
    {
        if($request->input('search-text'))
        {
            $result_page = new SearchResultPage();
            $result_page->getBody()->clear();
            try {
                $categories = Category::search([
                    'cols' => ['title'],
                    'operator' => 'LIKE',
                    'pattern' => "'%" . $request->input('search-text') . "%'"
                ]);
                $articles = Article::search([
                    'cols' => ['title'],
                    'operator' => 'LIKE',
                    'pattern' => "'%" . $request->input('search-text') . "%'"
                ]);
            }
            catch(QueryException $e) {
                $result_page->title = 'There was a problem with your search, try again.';
                return $this->returnPageView($result_page);
            }
            $result_page->title = 'Search results for: ' . $request->input('search-text');
            $this->assembleArticlesInPage(['page' => $result_page, 'articles' => $articles]);
            for($i=0;$i<count($categories);$i++)
            {
                $this->assembleCategoriesInPage(['page' => $result_page, 'category' => $categories[$i], 'is_in_body' => true, 'is_in_lnavbar' => false, 'is_in_rnavbar' => false, 'category_display_type' => 1]);
            }
            return $this->returnPageView($result_page);
        }
        return $this->returnPageView(new SearchResultPage());
    }

    /**
    *   Retrieves all page entities where the atribute 'isDisplayed' is true in order for them to be processed into a html navbar.
    *   @param Array $args Requires a 'selected_page' key in order for it to be underlined when its displayed. Optional.
    *   @return String $indexes HTML string containing the formatted menu indexes.
    */
    private function getIndexes(Array $args)
    {
        $indexes = null;
        $pages = $this->getDisplayedPages();
        for($i=0;$i<count($pages);$i++)
        {
            if(array_key_exists('selected_page', $args) and ($args['selected_page'] == $pages[$i]->id))
            {
                $indexes = $indexes . $this->builder->buildIndex(['page' => $pages[$i],'is_selected' => true, 'size' => count($pages)]);
            }
            else
            {
                $indexes = $indexes . $this->builder->buildIndex(['page' => $pages[$i],'is_selected' => false, 'size' => count($pages)]);
            }
        }
        return $indexes;
    }

    /**
    *   Retrieve all pages from database where the attribute 'isDisplayed' is true
    *   @return Collection A collection of pages entity.
    */

    private function getDisplayedPages()
    {
        $page_indexes = DB::table('pages')->select('pages.id')->where('isDisplayed', true)->get();
        $page_collection = new Collection();
        for($i=0;$i<count($page_indexes);$i++) $page_collection->push(Page::find($page_indexes[$i]->id));
        return $page_collection;
    }

    public function test()
    {
        $list = new DynamicList();
        return dd($list->render());
    }

}