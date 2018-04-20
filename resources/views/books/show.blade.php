@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"> <a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"> <a href="{{ route('books.index') }}">Penulis</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Penulis</li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-header">Data Buku</div>

                <div class="card-body">
                   Judul Buku : <strong>{{ $book->title }}</strong>
                   <br>
                   Id Author : <strong>{{ $book->author->name }}</strong>
                   <br>
                   Amount : <strong>{{ $book->amount }}</strong>
                   <br>
                   Cover :
                   <br>
                    <img src="{{ asset('cover/' . $book->cover) }}" width="700px" height="500px">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection