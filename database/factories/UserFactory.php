<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Book;
use App\Rating;

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

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->define(Book::class, function (Faker $faker) {
    return [
        'user_id'=> factory(User::class)->create()->id,
        'title'=> $faker->sentence($nbWords = 3, $variableNbWords = true),
        'description'=> $faker->paragraph($nbSentences = 3, $variableNbSentences = true)
    ];
});

$factory->define(Rating::class, function (Faker $faker) {
    return [
        'user_id'=> factory(User::class)->create()->id,
        'book_id'=> factory(Book::class)->create()->id,
        'rating'=> $faker->numberBetween($min = 1, $max = 10)
    ];
});
