<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10)
    ];
});

$factory->define(App\Category::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(),
        'description' => $faker->sentence(),
        'color' => $faker->hexColor
    ];
});

$factory->define(App\Article::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(5),
        'description' => $faker->sentence(5),
        'content' => implode('<br/><br/>', $faker->paragraphs(8)),
        'published_at' => $faker->date($format = 'Y-m-d', $max = 'now'),
    ];
});
