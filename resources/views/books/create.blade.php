@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('books.index') }}">Buku</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Buku</li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-header">Tambah Buku</div>
                    <div class="card-body">
                        <form class="form-horizontal" action="{{ route('books.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                    <label for="name" class="col-md-2 control-label">Buku</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : ''}}" id="title" name="title" placeholder="Judul Buku" value="{{ old('name') }}" autofocus>
                                        @if ($errors->has('title'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                
                                    <br>
                                    
                                    <label for="name" class="col-md-2 control-label">Penulis</label>
                                    <div class="col-md-4">
                                        <select class="form-control js-selectize {{ $errors->has('author_id') ? ' is-invalid' : ''}}" name="author_id">
                                            {{-- <option selected>**Pilih Penulis**</option> --}}
                                            @foreach ($authors as $author)
                                                <option value="{{ $author->id }}">{{ $author->name }}</option>
                                            @endforeach
                                        </select>
                                            @if ($errors->has('author_id'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('author_id') }}</strong>
                                                </span>
                                            @endif
                                    </div>
                                
                                    <br>
                                    
                                    <label for="name" class="col-md-2 control-label">Stock</label>
                                    <div class="col-md-4">
                                        <input type="number" class="form-control {{ $errors->has('amount') ? ' is-invalid' : ''}}" id="amount" name="amount" placeholder="Jumlah Stock" value="{{ old('name') }}" autofocus>
                                        @if ($errors->has('amount'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('amount') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <br>

                                    <label for="name" class="col-md-2 control-label">Upload Cover</label>
                                    <div class="col-md-4">
                                        <input type="file" class="form-control" id="cover" name="cover" value="{{ old('name') }}" autofocus>
                                        </span>
                                    </div>
                                    
                                    
                                </div>
                                <div class="form-group">
                                    <div class="col-md-4 col-md-offset-2">
                                        <button type="submit" class="btn btn-primary">Tambah</button>
                                    </div>
                                </div> 

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection