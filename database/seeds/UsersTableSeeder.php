<?php

use Illuminate\Database\Seeder;
use App\User as User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('users')->delete();
        User::create(['name' => 'Stef',
         'email' => 'admin@admin.com',
         'password' => bcrypt('secret'),
         'picture_url' => "https://thumb9.shutterstock.com/display_pic_with_logo/1142849/149083895/stock-vector-male-avatar-profile-picture-vector-149083895.jpg",
        ]);
    }
}
