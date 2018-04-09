<?php

use Illuminate\Database\Seeder;
use App\Setting as Setting;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('settings')->delete();
        Setting::create(['id' => 1, 'email' => 'me@example.com', 'facebook' => 'http://facebook.com/myProfile', 'twitter' => 'http://twitter.com/myProfile']);
    }
}
