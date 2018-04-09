<?php

use Illuminate\Database\Seeder;

class CategoryDisplayTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category_display_type')->insert([
        	['name' => 'Rows'],
        	['name' => 'Columns'],
        	['name' => 'List']
        ]);
    }
}
