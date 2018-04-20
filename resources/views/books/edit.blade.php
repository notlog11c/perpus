@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"> <a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"> <a href="{{ route('books.index') }}">Buku</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Buku</li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-header">Edit Buku</div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route ('books.update', $book->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label for="text" class="col-md-2 control-label">Judul</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : ''}}" id="title" name="title" value="{{ $book->title }}" autofocus>
                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback">
                                            <strong> {{ $errors->first('title') }} </strong>
                                        </span>
                                    @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="text" class="col-md-2 control-label">Penulis</label>
                            <div class="col-md-4">
                                <select class="costum-select form-control js-selectize {{ $errors->has('author_id') ? ' is-invalid' : ''}}" name="author_id">
                                    @foreach ($authors as $author)
                                        <option value="{{ $author->id }}"
                                            @if($book->author_id == $author->id)
                                                selected
                                            @endif>
                                            {{ $author->name }}
                                        </option>
                                    @endforeach
                                </select>
                                    @if ($errors->has('author_id'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('author_id') }}</strong>
                                        </span>
                                    @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="text" class="col-md-2 control-label">Stock</label>
                            <div class="col-md-4">
                                <input type="number" class="form-control {{ $errors->has('amount') ? ' is-invalid' : ''}}" id="amount" name="amount" value="{{ $book->amount }}">
                                @if ($errors->has('amount'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('amount') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <br>
                        <div class="from-group">
                            <label for="text" class="col-md-2 control-label">Upload Cover</label>
                            <div class="col-md-4">
                                <input type="file" class="costum-file-input" id="cover" name="cover" value="{{ $book->cover }}">
                                @if ($errors->has('cover'))
                                    <span class="invalid-feedback">
                                        <strong> {{ $errors->first('cover') }} </strong>
                                    </span>
                                @endif
                            </div>
                            <br>
                            @if ($book->cover)
                                <img src="{{ asset('cover/' .$book->cover) }}" width="100px" height="100px">
                            @endif
                        </div>
                        <br>                      
                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-2">
                                <button type="submit" class="btn btn-primary">Edit</button>
                            </div>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection