<!-- resources/views/your_view.blade.php -->

@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Selesai Dipinjam</div>
    <div class="card-body">
        <!-- dropdown -->
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
                @foreach ($selesai as $key => $item)
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
<div class="card">
    <div class="card-header">Buku Sedang Dipinjam</div>
    <div class="card-body">
        <!-- dropdown -->
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
                @foreach ($dipinjam as $key => $item)
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
<div class="card">
    <div class="card-header">Lewat Masa Peminjaman</div>
    <div class="card-body">
        <!-- dropdown -->
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
                @foreach ($lewat as $key => $item)
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