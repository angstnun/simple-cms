<?php

use Illuminate\Database\Seeder;

class PagePreferencesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pages_article_preferences')->insert([
        	['page_id' => 1, 'is_ordered_asc' => false]
        ]);
    }
}
