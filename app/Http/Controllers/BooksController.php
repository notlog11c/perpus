<?php

namespace App\Http\Controllers;

use App\Book;
use App\Author;
use App\BorrowLog;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Exceptions\BookException;
use Yajra\DataTables\Html\Builder;
use App\Http\Requests\BookRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Contracts\FileSystem\FileNotFoundException;

class BooksController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:member'])->only(['borrow']);
    }

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
    public function show(Book $book)
    {
        return view('books.show', compact ('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $authors = Author::all();

        return view('books.edit', compact('book', 'authors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookRequest $request, Book $book)
    {
        if(!$book->update($request->all())) {
            return redirect()->back();
        }

        if ($request->hasFile('cover')){
            $filename = null;
            $uploaded_image = $request->file('cover');
            $extension = $uploaded_image->getClientOriginalExtension();

            $filename = md5(time()) . '.' . $extension;

            $destinationPath = public_path() . DIRECTORY_SEPARATOR . 'cover';

            $uploaded_image->move($destinationPath, $filename);

            if ($book->cover) {
                $old_image = $book->cover;
                $filePath = public_path() . DIRECTORY_SEPARATOR . 'cover' . DIRECTORY_SEPARATOR . $book->cover;

                try {
                    File::delete($filePath);
                } catch (FileNotFoundException $e) {

                }
                
                $book->cover = $filename;
                $book->save();
            }
        }

        return redirect()->route('books.index')->with('flash_notification', [
            'level' => 'succes',
            'message' => 'Berhasil Memperbaharui Judul ' . $book->title
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $cover = $book->cover;
        
        if (!$book->delete()) {
            return redirect()->back();
        }

        if ($cover) {
            $old_image = $book->cover;
            $filePath = public_path() . DIRECTORY_SEPARATOR . 'cover' . DIRECTORY_SEPARATOR . $book->cover;
    
            try {
                File::delete($filePath); 
            }
            catch (FileNotFoundException $e) {
            }
        }
        

            return redirect()->route('books.index')->with('flash_notification', [
                'level' => 'danger',
                'message' => 'Berhasil Menghapus Data Penulis Dengan Nama <strong class="text-danger">' . $book->title . '</strong'
        ]);
    }

    public function borrow(Book $book)
    {
        try {
            auth()->user()->borrow($book);
                
            Session::flash('flash_notification', [
                'level' => 'success',
                'message' => 'Berhasil Meminjam Buku' .$book->title
            ]);

        } catch (BookException $e) {
            Session::flash('flash_notification', [
                'level' => 'danger',
                'message' => $e->getMessage()
            ]);

        } catch (ModelNotFoundException $e) {
            Session::flash('flash_notification', [
                'level' => 'danger',
                'message' => 'Buku tidak ditemukan'
            ]);
        }

        return redirect('/');
    }

    public function return(Book $book)
    {
        $borrowLog = BorrowLog::where('user_id', auth()->user()->id)
                    ->where('book_id', $book->id)
                    ->where('is_returned', 0)
                    ->first();

        if ($borrowLog) {
            $borrowLog->is_returned = 1;
            $borrowLog->save();

            Session::flash('flash_notification', [
                'level' => 'success',
                'message' => 'Berhasil mengembalikan buku ' .$borrowLog->book->title
            ]);
        }
        return redirect('/home');
    }
    
}
