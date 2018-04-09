<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\Article;

class CategoriesArticlesTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('categories_article')->delete();

		for($i = 0; $i < 30; $i++)
		{
			try 
			{
				DB::table('categories_article')->insert([
					'category_id' => rand(1, Category::count('id')),
					'article_id' => rand(1, Article::count('id'))]);
			}
			catch(Illuminate\Database\QueryException $e)
			{
			}
		}
	}
}