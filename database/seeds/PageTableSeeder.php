<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pages')->insert(['title' => 'Pictures',
        	'description' => 'Just some random pictures, provided by lorem().',
            'isDisplayed' => true,
            ]);

        DB::table('pages')->insert(['title' => 'Portfolio',
        	'description' => "Projects I've worked on",
            'isDisplayed' => true,
            ]);

        DB::table('pages')->insert(['title' => 'Page 3',
        	'description' => 'Example page',
            'isDisplayed' => true,
        	]);
    }
}
