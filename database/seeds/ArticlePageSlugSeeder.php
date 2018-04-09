<?php

use Illuminate\Database\Seeder;
use App\Page;
use App\Category;
use App\Slug;

class ArticlePageSlugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = Page::all();
        $slug = new Slug();
        for($i=0;$i<count($pages);$i++)
        {
        	$pages[$i]->slug = $slug->generateSlug(['title' => $pages[$i]->title]);
        	$pages[$i]->save();
        }
        
        $categories = Category::all();
        for($i=0;$i<count($categories);$i++)
        {
        	$categories[$i]->slug = $slug->generateSlug(['title' => $categories[$i]->title]);
        	$categories[$i]->save();
        }
    }
}
