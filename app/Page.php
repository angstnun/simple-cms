<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Category;
use App\PageCategory;
use App\Homepage;
use App\Page\Body;
use App\Page\Sidebar;
use App\Page\Footer;
use App\PagePage;
use App\Setting;

class Page extends Model
{
    protected $fillable = ['content', 'description', 'title', 'isDisplayed'];

    protected $navbar;
    protected $body;
    protected $left_bar;
    protected $right_bar;
    protected $footer;

    public function __construct()
    {
        parent::__construct();
        $this->navbar = null;
        $this->body = new Body();
        $this->left_bar = new Sidebar();
        $this->right_bar = new Sidebar();
        $this->footer = new Footer(Setting::first());
    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function (Page $page) 
        {
            $page_pages = $page->pagePages();
            $pages_page = PagePage::where('page_id_1', $page->id)->get();
            $page_category = $page->pageCategories();
            $page_articles = $page->pageArticles();
            for($i=0;$i<count($page_pages);$i++){ $page_pages[$i]->delete(); }
            for($i=0;$i<count($pages_page);$i++){ $pages_page[$i]->delete(); }
            for($i=0;$i<count($page_category);$i++){ $page_category[$i]->delete(); }
            for($i=0;$i<count($page_articles);$i++){ $page_articles[$i]->delete(); }
        });
    }

    public function setBody(Body $body)
    {
        $this->body = $body;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getFooter()
    {
        return $this->footer;
    }

    public function setLeftbar(Sidebar $sidebar)
    {
        $this->left_bar = $sidebar;
    }

    public function getLeftbar()
    {
        return $this->left_bar;
    }

    public function setRightbar(Sidebar $sidebar)
    {
        $this->right_bar = $sidebar;
    }

    public function getRightbar()
    {
        return $this->right_bar;
    }

    public function setSizes()
    {
        if($this->left_bar->getContent() xor $this->right_bar->getContent())
        {
            if($this->left_bar->getContent())
            {
                $this->left_bar->setSize(3);
            }
            else
            {
                $this->right_bar->setSize(3);
            }
            $this->body->setSize(9);
        }
        else if($this->left_bar->getContent() and $this->right_bar->getContent())
        {
            $this->left_bar->setSize(3);
            $this->right_bar->setSize(3);
            $this->body->setSize(6);
        }
        else
        {
            $this->body->setSize(12);
        }

    }

    public function pagePages()
    {
        return PagePage::where('page_id_0', $this->id)->get();
    }

    /**
    *   Retrieve pivot table Page-Categories entity, it holds attributes as to how the categories should be displayed when this page entity is requested.
    *
    *   @return Collection. Page-Categories entities.
    */
    public function pageCategories()
    {
        return PageCategory::where('page_id', $this->id)->get();
    }

    public function pageArticles()
    {
        return PageArticle::where('page_id', $this->id)->get();
    }

    public function categories()
    {
        $page_categories = $this->pageCategories();
        $categories = new Collection();
        for($i=0;$i<count($page_categories);$i++) $categories->push($page_categories[$i]->category());
        return $categories;
    }

    public function pages()
    {
        $page_pages = $this->pagePages();
        $pages = new Collection();
        for($i=0;$i<count($page_pages);$i++) $pages->push($page_pages[$i]->page());
        return $pages;
    }

    public function articles()
    {
        $page_articles = $this->pageArticles();
        $articles = new Collection();
        for($i=0;$i<count($page_articles);$i++) $articles->push($page_articles[$i]->article());
        return $articles;
    }

    public function paginatedPages($count)
    {
        return DB::table('pages')
            ->select('id', 'title', 'description')
            ->orderBy('pages.id')
            ->paginate($count);
    }
}
