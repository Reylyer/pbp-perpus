<!-- resources/views/your_view.blade.php -->

@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Kategori List</div>
    <div class="card-body">
        <a href="{{ route('kategori.create') }}" class="btn btn-primary">+ Add New Category</a>
        <table class="table table-striped mt-2">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Buku</th>
                    <th>Peminjam</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Denda</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->peminjam}}</td>
                    <td>{{ $item->tgl_pinjam}}</td>
                    <td>{{ $item->tgl_kembali}}</td>
                    <td>{{ $item->denda}}</td>
                    <td>
                        {{-- fix missing parameter idkategori --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection