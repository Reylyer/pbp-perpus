<!-- resources/views/update.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Kategori</h2>
        <form action="{{ route('crudbuku.doUpdate', ['idbuku' => $data->idbuku]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                {{-- buku (isbn, judul, pengarang, penerbit, kota_terbit, editor, file_gambar, stok, stok_tersedia, idkategori, tahun_terbit, tgl_insert, tgl_update) --}}
                <label for="isbn">ISBN:</label>
                <input type="text" class="form-control" id="isbn" name="isbn" value="{{ $data->isbn }}">

                <label for="judul">Judul:</label>
                <input type="text" class="form-control" id="judul" name="judul" value="{{ $data->judul }}">

                <label for="pengarang">Pengarang:</label>
                <input type="text" class="form-control" id="pengarang" name="pengarang" value="{{ $data->pengarang }}">

                <label for="penerbit">Penerbit:</label>
                <input type="text" class="form-control" id="penerbit" name="penerbit" value="{{ $data->penerbit }}">

                <label for="kota_terbit">Kota terbit:</label>
                <input type="text" class="form-control" id="kota_terbit" name="kota_terbit" value="{{ $data->kota_terbit }}">

                <label for="editor">Editor:</label>
                <input type="text" class="form-control" id="editor" name="editor" value="{{ $data->editor }}">

                <label for="file_gambar">Cover:</label>
                <input type="file" class="form-control" id="file_gambar" name="file_gambar" value="{{ $data->file_gambar }}">

                <label for="stok">Stok:</label>
                <input type="number" class="form-control" id="stok" name="stok" value="{{ $data->stok }}">

                <label for="stok_tersedia">Stok tersedia:</label>
                <input type="number" class="form-control" id="stok_tersedia" name="stok_tersedia" value="{{ $data->stok_tersedia }}">

                <label for="idkategori">Kategori:</label>
                <select class="form-control" name="idkategori">
                @foreach ($kategori_pair as $kp)
                    <option value="{{ $kp->idkategori }}"> {{ $kp->nama }}</option>
                @endforeach
                </select>

                <label for="tahun_terbit">Tahun terbit:</label>
                <input type="text" class="form-control" id="tahun_terbit" name="tahun_terbit" value="{{ $data->tahun_terbit }}">

                <label for="tgl_insert">Tanggal insert:</label>
                <input type="text" class="form-control" id="tgl_insert" name="tgl_insert" value="{{ $data->tgl_insert }}">

                <label for="tgl_update">Tanggal update:</label>
                <input type="text" class="form-control" id="tgl_update" name="tgl_update" value="{{ $data->tgl_update }}">

            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('crudbuku.list') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
