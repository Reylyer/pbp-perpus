@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card mt-4">
    <div class="card-header">Register</div>
    <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" autocomplete="on" action="" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="nama" class="form-control" id="nama" name="nama" value="">
            </div>
            <br>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="">
            </div>
            <br>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" value="">
            </div>
            <br>
            <div class="form-group">
                <label for="confirm_password">Konfirmasi password:</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" value="">
            </div>
            <br>
            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="">
            </div>
            <br>
            <div class="form-group">
                <label for="kota">Kota:</label>
                <input type="text" class="form-control" id="kota" name="kota" value="">
            </div>
            <br>
            <div class="form-group">
                <label for="no_telp">Nomor telepon:</label>
                <input type="text" class="form-control" id="no_telp" name="no_telp" value="">
            </div>
            <br>
            <div class="form-group">
                <label for="noktp">Nomor KTP:</label>
                <input type="text" class="form-control" id="noktp" name="noktp" value="">
            </div>
            <br>
            <div class="form-group">
                <label for="file_ktp">KTP:</label>
                <input type="file" class="form-control" id="file_ktp" name="file_ktp" required>
            </div>
            <br>
            <button type="submit" class="btn btn-primary" name="submit" value="submit">Daftar!</button>
        </form>
    </div>
    </div>
</div>


@endsection