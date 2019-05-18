<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /**
         * generating 50 fake users
         */
        $users = factory(App\User::class, 50)->create();

        /**
         * for each create 3 books and 3 ratings
         */
        $users->each(function ($user) {
            $books = $user
                ->books()
                ->saveMany(factory(App\Book::class, 3)->make());
            $books->each(function ($book) {
                $book
                    ->ratings()
                    ->saveMany(factory(App\Rating::class, 3)->make());
            });
        });
    }
}
