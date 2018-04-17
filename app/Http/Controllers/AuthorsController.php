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

            return DataTables::of($authors)->toJson();
        }
        $html = $htmlBuilder->columns([
            ['data' => 'name', 'name' => 'name', 'title' => 'Nama']
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
}
