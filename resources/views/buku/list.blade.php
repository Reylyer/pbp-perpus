@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Books Data</div>
        <div class="card-body">
            <form action="" class="d-flex" method="GET">
                <input id="search" class="form-control me-2" name="s" type="text" placeholder="Search book">
                <button class="btn btn-outline-primary" type="submit">Search</button>
            </form>

            <table class="table table-striped mt-2" id="tabel-buku">
                <thead>
                    <tr>
                        <th>ISBN</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Pengarang</th>
                        <th>Penerbit</th>
                        <th>Tahun terbit</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($books as $book)
                        <tr>
                            <td>{{ $book->isbn }}</td>
                            <td>{{ $book->judul }}</td>
                            <td>{{ $book->nama_kategori }}</td>
                            <td>{{ $book->pengarang }}</td>
                            <td>{{ $book->penerbit }}</td>
                            <td>{{ $book->tahun }}</td>
                            <td><a href="{{ route('buku.show', ['idbuku' => $book->idbuku]) }}"><button
                                        class="btn btn-primary btn-sm">Lihat Detail</button></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
