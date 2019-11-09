<?php

use Illuminate\Database\Seeder;

class AuthorBookTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get all the Authors
        $authors = App\Author::all();

        // For each book attach one or two authors
        App\Book::all()->each(function ($book) use ($authors) {
            $book->authors()->attach(
                $authors->random(rand(1, 2))->pluck('id')->toArray()
            );
        });
    }
}
