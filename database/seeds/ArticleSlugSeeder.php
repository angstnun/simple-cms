<?php

use Illuminate\Database\Seeder;
use App\Article;
use App\Slug;

class ArticleSlugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $articles = Article::all();
        $slug = new Slug();
        for($i=0;$i<count($articles);$i++)
        {
        	$articles[$i]->slug = $slug->generateSlug(['title' => $articles[$i]->title]);
        	$articles[$i]->save();
        }
    }
}
