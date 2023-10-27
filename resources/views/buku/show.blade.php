@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mt-3">
            <div class="card-header">Book Details</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-9">
                        <img src="{{ asset('uploads/'.$book->file_gambar) }}" class="img-fluid" alt={{ $book->file_gambar }}>
                        <table class="table">
                            <tr>
                                <th>ISBN</th>
                                <td>{{ $book->isbn }}</td>
                            </tr>
                            <tr>
                                <th>Judul</th>
                                <td>{{ $book->judul }}</td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td>{{ $book->kategori }}</td>
                            </tr>
                            <tr>
                                <th>Pengarang</th>
                                <td>{{ $book->pengarang }}</td>
                            </tr>
                            <tr>
                                <th>Tahun</th>
                                <td>{{ $book->tahun }}</td>
                            </tr>
                            <tr>
                                <th>Penerbit</th>
                                <td>{{ $book->penerbit }}</td>
                            </tr>
                            <tr>
                                <th>Kota Terbit</th>
                                <td>{{ $book->kota_terbit }}</td>
                            <tr>
                                <th>Stok</th>
                                <td>{{ $book->stok }}</td>
                            </tr>
                            <tr>
                                <th>Stok Tersedia</th>
                                <td>{{ $book->stok_tersedia }}</td>
                            </tr>
                            <tr>
                                <th>Rating</th>
                                <td>
                                    @if ($rating == 0)
                                    Belum ada rating
                                    @else
                                    {{ $rating }}
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">Komentar Pengguna</div>
            <div class="card-body">
                @foreach ($komentar as $k)
                <div class="card mt-3">
                    <div class="card-header">{{$k->nama}}</div>
                    <div class="card-body">
                        {{ $k->komentar }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="card mt-3">
        <div class="card-header">Add a Review</div>
        <div class="card-body">
            <form action="{{ route('buku.komentar', ['idbuku' => $book->idbuku]) }}" method="POST">
                @csrf
                <textarea name="komentar" class="form-control" rows="5" placeholder="Leave a review here" id="floatingTextarea">
                </textarea>
                <button class="btn btn-primary mt-3" type="submit" name="submit">Submit</button>
            </form>
        </div>
    </div>
    </div>

    </div>
@endsection
