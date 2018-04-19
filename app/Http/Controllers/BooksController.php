<?php

namespace App\Http\Controllers;

use Session;
use App\Book;
use App\Author;
use Illuminate\Http\Request;
use App\Http\Requests\BookRequest;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;


class BooksController extends Controller
{
    public function index(Request $request, Builder $htmlBuilder)
    {
        if ($request->ajax()){
            $books = Book::with('author')->get();

            return DataTables::of($books)->addColumn('action', function($book){
                return view('datatable._action', [
                    'show_url' => route('books.show', $book->id),
                    'edit_url' => route('books.edit', $book->id),
                    'delete_url' => route('books.destroy', $book->id),
                    'confirm_message' => 'Yakin Ingin Menghapus Data ' . $book->name                    
                ]);
            })->toJson();
        }

        $html = $htmlBuilder->columns([
            ['data' => 'title', 'name' => 'title', 'title' => 'Judul Buku'],
            ['data' => 'cover', 'name' => 'cover', 'title' => 'Sampul'],
            ['data' => 'amount', 'name' => 'amount', 'title' => 'Stock'],
            ['data' => 'author.name', 'name' => 'author.name', 'title' => 'Nama Pengarang'],
            ['data' => 'action', 'name' => 'action', 'title' => '', 'orderable' => false, 'searchable' => false],
        ]);

            return view('books.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authors = Author::all();

        return view('books.create', compact('authors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request)
    {
        $book = Book::create($request->except('cover'));

            // cek jika user mengupload gambar
        if ($request->hasFile('cover')) {
            
            // ambil file yang diupload
            $uploaded_image = $request->file('cover');

            // mengambil extension file
            $extension = $uploaded_image->getClientOriginalExtension();
            
            // membuat nama file secara acak, untuk mencegah duplikasi nama gambar
            $filename = md5(time()) . '.' . $extension;

            // simpan gambar ke folder public/cover
            $destinationPath = public_path() . DIRECTORY_SEPARATOR . 'cover';

            $uploaded_image->move($destinationPath, $filename);

            // simpan filename ke database
            $book->cover = $filename;
            $book->save();
        }

        return redirect()->route('books.index')->with('flash_notification', [
            'level' => 'succes',
            'message' => 'Berhasil Menyimpan Buku Dengan Judul ' . $book->title
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
