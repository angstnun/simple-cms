<?php

use Illuminate\Database\Seeder;

class ArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
 */
    public function run()
    {
    	DB::table('article')->delete();
        factory(App\Article::class, 10)->create();
    }
}
