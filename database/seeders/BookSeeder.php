<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

use App\Models\Book;
use App\Models\User;
use App\Models\Author;

class BookSeeder extends Seeder
{
    public function run()
    {
        DB::table("books")->delete();
       
        for($i =0; $i < 50; $i++){

            $book = Book::create([
                'title' => "Sample Book $i",
                'year' => 2022,
                'filiere' => Arr::random(["Mathematics","Computer Science","Biology","Industrial Security"]),// Replace with the actual filiere
                'pdfLink' => 'https://example.com/sample-book-2.pdf',
            ]);

            $author = Author::create([
                "user_id" => Arr::random(User::pluck('id')->toArray()),
                "book_id" => $book->id
            ]);
            
        }

        // Add more books as needed
    }
}
