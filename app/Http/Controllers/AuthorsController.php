<?php

namespace App\Http\Controllers;

use Session;
use App\Author;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class AuthorsController extends Controller
{
    public function index(Request $request, Builder $htmlBuilder)
    {
        // cara biasa
        // $authors = Author::all();
        // return view('authors.index', compact('authors'));
        
        // cara dataTables
        if ($request->ajax()){
            $authors = Author::all();

            return Datatables::of($authors)
                    ->addColumn('action', function($author){
                        return view('datatable._action',[
                            'author_id' => $author->id,
                            'edit_url' => route('authors.edit', $author->id),
                            'show_url' => route('authors.show', $author->id),
                            'delete_url' => route('authors.destroy', $author->id),
                            'confirm_message' => 'Yakin Akan Menghapus ' . $author->name   
                        ]);
                    })->toJson();
        }

        $html = $htmlBuilder->columns([
            ['data' => 'name', 'name' => 'name', 'title' => 'Nama'],
            ['data' => 'action', 'name' => 'action', 'title' => '', 'orderable' => false, 'searchable' => false],
        ]);

        return view('authors.index', compact('html'));
    } 

    public function create()
    {
        return view('authors.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|unique:authors'
        ],
        [
            'name.required' => 'Field Tidak Boleh Kosong!',
            'name.unique' => 'Nama Penulis Sudah Ada!'
        ]);

        $author = Author::create($request->all());

        
        return redirect()->route('authors.index')->with('flash_notification', [
            'level' => 'primary',
            'message' => 'Berhasil ditambahkan ' . $author->name
            ]);
                        // Session::flash('flash_notification', [
                        //     'level' => 'danger',
                        //     'message' => 'Berhasil Menyimpan Data' . $author->name
                        // ]);
    }

    public function show(Author $author)
    {
        return view('authors.show', compact ('author'));
    }

    public function edit(Author $author)
    {
        return view('authors.edit', compact ('author'));
    }

    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required|unique:authors,name,' . $author->id
        ],
        [
            'name.required' => 'Field Tidak Boleh Kosong!',
            'name.unique' => 'Nama Sudah Ada!'
        ]);

        $author->update($request->only('name'));

        return redirect()->route('authors.index')->with('flash_notification', [
            'level' => 'succes',
            'message' => 'Berhasil Mengedit Data Penulis Dengan Nama <strong class="text-primary">' . $author->name . '</strong'
        ]);
    }

    public function destroy(Author $author)
    {
        if (!$author->delete()) {
            return redirect()->back();
        }

        return redirect()->route('authors.index')->with('flash_notification', [
            'level' => 'danger',
            'message' => 'Berhasil Menghapus Data Penulis Dengan Nama <strong class="text-danger">' . $author->name . '</strong'
        ]);
    }
}

