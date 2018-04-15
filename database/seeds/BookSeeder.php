<?php

use App\Book;
use App\Author;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //sample penulis
        $author1 = Author::create(['name' => 'Daesuki' ]);
        $author2 = Author::create(['name' => 'Golezan' ]);
        $author3 = Author::create(['name' => 'Zaza' ]);

        //sampel buku
        $book1 = Book::create([
            'title' => 'air susu sapi enak lho',
            'amount' => 3,
            'author_id' => $author1->id,
        ]);

        $book2 = Book::create([
            'title' => 'Sate kambing muda!',
            'amount' => 5,
            'author_id' => $author1->id,
        ]);

        $book3 = Book::create([
            'title' => 'Nasi Goreng Seafood',
            'amount' => 17,
            'author_id' => $author3->id,
        ]);

        $book4 = Book::create([
            'title' => 'aku suka kamu steak daging!',
            'amount' => 4,
            'author_id' => $author2->id,
        ]);
    }
}
