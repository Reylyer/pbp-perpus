@extends('layouts.app')

@section('content')
    <div class="">
        {{-- Book Detail --}}
        <div class="card">
            <div class="card-header">Book Details</div>
            <div class="card-body">
                <div class="d-flex align-items-center gap-5">
                    <table class="table w-75">
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
                            <th>Tahun terbit</th>
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
                                @if ($rating == null)
                                    Belum ada rating
                                @else
                                    {{ $rating }} / 5
                                @endif
                            </td>
                        </tr>
                    </table>
                    <img src="{{ asset('storage/images/' . $book->file_gambar) }}" class="img-fluid w-25"
                        alt={{ $book->file_gambar }}>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (Auth::guard('anggota')->check())
        {{-- Add Rating --}}
        <div class="card mt-3">
            <div class="card-header">Beri Rating Buku</div>
            <div class="card-body">
                <form action="{{ route('buku.rating', ['idbuku' => $book->idbuku]) }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <select class="form-select" id="rating" name="rating">
                            <option selected>Mau kasih berapa bintang...</option>
                            <option value="1">⭐</option>
                            <option value="2">⭐⭐</option>
                            <option value="3">⭐⭐⭐</option>
                            <option value="4">⭐⭐⭐⭐</option>
                            <option value="5">⭐⭐⭐⭐⭐</option>
                        </select>
                        <button class="btn btn-outline-primary" type="submit" name="submit">Kirim</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Add Comment --}}
        <div class="card mt-3">
            <div class="card-header">Beri Komentar</div>
            <div class="card-body">
                <form action="{{ route('buku.komentar', ['idbuku' => $book->idbuku]) }}" method="POST">
                    @csrf
                    <textarea name="komentar" class="form-control" rows="5" placeholder="" id="floatingTextarea"></textarea>
                    <button class="btn btn-primary mt-3" type="submit" name="submit">Kirim</button>
                </form>
            </div>
        </div>
        @endif

        {{-- Comment List --}}
        <div class="card mt-3">
            <div class="card-header">Apa Kata Mereka Dari Buku Ini</div>
            <div class="card-body d-flex flex-wrap gap-2">
                @foreach ($komentar as $k)
                    <div class="card" style="max-width: 320px">
                        <div class="card-body">
                            <div class="card-title fw-bolder">{{ $k->nama }}</div>
                            <div class="card-text">{{ $k->komentar }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
