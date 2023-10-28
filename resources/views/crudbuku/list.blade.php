@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Books Data</div>
        <div class="card-body">
            <a href="{{ route('crudbuku.create') }}" class="btn btn-primary">+ Add New Book</a>
            <form action="" class="d-flex mt-3" method="GET">
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
                        <th>Tahun</th>
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
                            <td>
                                {{-- fix missing parameter idbuku --}}
                                <a href="{{ route('crudbuku.show', ['idbuku' => $book->idbuku]) }}" class="btn btn-primary">View</a>
                                <a href="{{ route('crudbuku.update', ['idbuku' => $book->idbuku]) }}" class="btn btn-success">Edit</a>
                                <form action="{{ route('crudbuku.doDelete', ['idbuku' => $book->idbuku]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
