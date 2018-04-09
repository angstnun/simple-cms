<?php

namespace App\Acid;
use App\Acid\NavbarMaker;
use Illuminate\Support\Collection;
use App\Page;
use App\Category;
use App\Article;

class HomeMaker
{

	public function buildArticleMetaDiv(Article $article)
	{
		return $metadiv = "<div class='meta'>
			<ul class='data'>
				<li class='meta-author'>
					<span class='meta-label'>By</span>
					<a href='/?author=" . $article->user->id . "' rel='author'>" . $article->user->name . "</a></li>
				<li class='meta-date'>
					<span class='meta-label'>Posted on</span>"
					. date('M d, Y' ,strtotime($article->published_at))
					. "</li></ul></div>";
	}

	/**
	*	Make a <li> style list for articles.
	*	@param Collection. $articles.
	*	@return String. HTML list.
	*/
	public function buildArticleList($args)
	{
		$data = null;
		$data = $data . "<div class='article-list-container'><ul class='article-list" . $args['ul_classes'] . "'>";

		for($i=0;$i<count($args['articles']);$i++)
		{
			$data = $data . "<li><a href='/" 
						. $args['articles'][$i]->slug
						. "'>"
			 			. $args['articles'][$i]->title 
			 			. "</a></li>";

		}
		
		$data = $data . "</ul></div></div>";
		return $data;
	}

	/**
	*	Make an html header string
	*	@param Array. $args. Needs a header size ie. 1, 2, 3, etc in a 'size' key and a 'title' string.
	*/
	public function buildCategoryHeader(Array $args)
	{
		return '<div class=\'category-list-header\'>' . $args['title'] . '</div>';
	}

	/**
	*	Columns and rows articles table
	*	@param Collection. $articles.
	*	@return String. HTML article table, built out of divs.
	*/
	public function buildArticleTable(Collection $articles)
	{
		$data = '<div class=\'article-table readable-bg\'>';

		for($i=0;$i<count($articles);$i++)
		{

			$data = $data . "<div class='article-table-col'>";

			$data = $data . "<h3>" . $articles[$i]->title . "</h3>";

			$data = $data . $this->shortenContent($articles[$i]->content) . '...' 
			. "</br><a href='/" . $articles[$i]->slug . "'>Read the full article</a>" . "</div>";

		}

		$data = $data . "</div>";

		return $data;
	}

	/**
	*	Get a row style list for articles
	*	@param Collection. $articles.
	*	@return String. HTML row list.
	*/
	public function buildArticleRows(Collection $articles)
	{
		$data = null;

		for($i=0;$i<count($articles);$i++)
		{
			$data = $data 
					. "<div class='article-row readable-bg'>"
					. "<div class='article-title'>"
					. "<h2>"
					. $articles[$i]->title 
					. "</h2></div>"
					. $this->buildArticleMetaDiv($articles[$i])
					. "<div class='article-content'>" . $articles[$i]->content . "</div>"
					. "</div>";
		}
		return $data;
	}


	private function shortenContent($content)
	{
		$shortened = explode('<br/><br/>', $content);
		$shortened = implode('<br/><br/>', array_slice($shortened, 0 , 4));
		return $shortened;
	}

	/**
	*	Make a html li style index
	*	@param Array. $args. Can have an optional boolean key 'is_selected' but must have a Page object from which to build the index.
	*	@return String. HTML index.
	*/
	public function buildIndex($args)
    {
        $index = null;

        $is_selected = $args['is_selected'] ? ' navbar-item-selected ' : '';

        $page_pages = $args['page']->pagePages();

        if($page_pages->first())
        {
            $index = $index . "<li class='navbar-item dropdown" . $is_selected . "'><a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>" . $args['page']->title . "  &#9660</a>";

            $index = $index . "<ul class='dropdown-menu'>";
            
            for($i=0;$i<count($page_pages);$i++) $index = $index . $this->buildIndex(['page' => $page_pages[$i]->page(), 'is_selected' => false, 'size' => $args['size']]);

            $index = $index . '</ul>';
        }
        else
        {
            $index = $index . "<li class='navbar-item " . $is_selected . "'><a href='/" . $args['page']->slug . "'>" . $args['page']->title . "</a>";
        }

        return $index;
    }
}