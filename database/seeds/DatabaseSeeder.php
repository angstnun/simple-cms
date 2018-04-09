<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(SettingTableSeeder::class);
        $this->call(ArticleTableSeeder::class);
        $this->call(PageTableSeeder::class);
        $this->call(HomepageSeeder::class);
        $this->call(ArticleSlugSeeder::class);
        $this->call(ArticlePageSlugSeeder::class);

        //Relationship seeders

        $this->call(CategoriesArticlesTableSeeder::class);
        $this->call(CategoryDisplayTypeSeeder::class);
    }
}
