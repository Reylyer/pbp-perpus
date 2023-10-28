<!-- resources/views/update.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Kategori</h2>
        <form action="{{ route('kategori.doUpdate', ['idkategori' => $data->idkategori]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" class="form-control" id="nama" name="nama" value="{{ $data->nama }}">
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('kategori.list') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
