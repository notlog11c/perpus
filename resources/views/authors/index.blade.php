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
                    <li class="breadcrumb-item active" aria-current="page">Penulis</li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-header">Penulis
                    <a class="btn btn-primary float-right" href="{{ route ('authors.create') }}">Tambah</a>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="card-body">
                    {{-- <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Nama Penulis</th>
                        </tr>
                        @foreach ($authors as $key => $author)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $author->name }}</td>
                            </tr>
                        @endforeach
                    </table> --}}
        
                    {!! $html->table([ 'class' => 'table-striped']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    {!! $html ->scripts() !!}
@endpush