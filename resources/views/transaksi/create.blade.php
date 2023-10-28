<!-- resources/views/create/kategori.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create a New Kategori</h2>
        <form action="{{ route('kategori.doCreate') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>

            <button type="submit" class="btn btn-primary">Create Kategori</button>
            <a href="{{ route('kategori.list') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
