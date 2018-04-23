@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">LIBRARYO</div>
                <div class="card-body">
                    <table class="table table-stripped">
                        <tbody>
                            <tr>
                                <td class="text-muted">Buku yang sedang dipinjam: </td>
                                <td>
                                    @if ($borrowLogs->count() == 0)
                                        Tidak ada buku yang dipinjam!
                                    @endif
                                    <ul>
                                    @foreach ($borrowLogs as $log)
                                    <li>
                                        {{ $log->book->title }}
                                        <form class="form-inline js-confirm" action="{{ route('member.books.return', $log->book->id) }}" method="post" data-confirm="Apakah anda yakin akan mengembalikan buku? {{ $log->book->title }}">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" class="btn btn-xs btn-default"> Kembalikan </button>
                                        </form>
                                    </li>
                                    @endforeach                                      
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
