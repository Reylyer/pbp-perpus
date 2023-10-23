@extends('layouts.app')

@section('content')
    <div class="container">
      <div class="card mt-3">
        <div class="card-header">Books Data</div>
        <div class="card-body">
          {{-- <a href="{{ route('books.add') }}" class="btn btn-primary">+ Add New Book</a> --}}
          <table class="table table-striped">
            <thead>
              <tr>
                <th>ISBN</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Pengarang</th>
                <th>Penerbit</th>
                <th>Tahun</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($books as $book)
              <tr>
                <td>{{$book->isbn}}</td>
                <td>{{$book->judul}}</td>
                <td>{{$book->kategori}}</td>
                <td>{{$book->pengarang}}</td>
                <td>{{$book->penerbit}}</td>
                <td>{{$book->tahun}}</td>
                <td><a href="{{ route('buku.show', ['isbn' => $book->isbn]) }}"><button class="btn btn-primary btn-sm">Lihat Detail</button></a></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
@endsection
