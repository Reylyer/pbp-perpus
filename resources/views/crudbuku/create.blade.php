@extends('layouts.app')

@section('content')
    <div class="container">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <h2>Add new book</h2>
        <form action="{{ route('crudbuku.doCreate') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="isbn">ISBN:</label>
                <input type="text" class="form-control" id="isbn" name="isbn" required>
            </div>
            <div class="form-group">
                <label for="judul">Judul:</label>
                <input type="text" class="form-control" id="judul" name="judul" required>
            </div>
            <div class="form-group">
                <label for="idkategori">Kategori:</label>
                <select class="form-control" name="idkategori">
                @foreach ($kategori_pair as $kp)
                    <option value="{{ $kp->idkategori }}"> {{ $kp->nama }}</option>
                @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="pengarang">Pengarang:</label>
                <input type="text" class="form-control" id="pengarang" name="pengarang" required>
            </div>
            <div class="form-group">
                <label for="penerbit">Penerbit:</label>
                <input type="text" class="form-control" id="penerbit" name="penerbit" required>
            </div>
            <div class="form-group">
                <label for="kota_terbit">Kota terbit:</label>
                <input type="text" class="form-control" id="kota_terbit" name="kota_terbit" required>
            </div>
            <div class="form-group">
                <label for="editor">Editor:</label>
                <input type="text" class="form-control" id="editor" name="editor" required>
            </div>
            <div class="form-group">
                <label for="file_gambar">Cover:</label>
                <input type="file" class="form-control" id="file_gambar" name="file_gambar" required>
            </div>
            <div class="form-group">
                <label for="stok">Stok:</label>
                <input type="number" class="form-control" id="stok" name="stok" required>
            </div>

            <button type="submit" class="btn btn-primary">Add buku</button>
            <a href="{{ route('crudbuku.list') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
