<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Yajra\DataTables\Html\Builder;
use Laratrust\LaratrustFacade as Laratrust;

class GuestController extends Controller
{
    public function index(Request $request, Builder $htmlBuilder)
    {
        if ($request->ajax()){
            $books = Book::with('author')->get();

            return DataTables::of($books)
                    ->addColumn('action', function($book){
                        if (Laratrust::hasRole('admin')){
                            return '';
                }

                return '<a class="btn btn-xs btn-primary" href="'. route ('guests.books.borrow', $book->id) . '"> Pinjam Buku </a>';

            })
            ->addColumn('stock', function ($book){
                return $book->stock;
            })
            ->toJson();
        }

        $html = $htmlBuilder->columns([
            ['data' => 'title', 'name' => 'title', 'title' => 'Judul Buku'],
            ['data' => 'cover', 'name' => 'cover', 'title' => 'Sampul'],
            ['data' => 'stock', 'name' => 'stock', 'title' => 'Stock'],
            ['data' => 'author.name', 'name' => 'author.name', 'title' => 'Nama Pengarang'],
            ['data' => 'action', 'name' => 'action', 'title' => '', 'orderable' => false, 'searchable' => false],
        ]);

            return view('guests.index', compact('html'));
    }
}
