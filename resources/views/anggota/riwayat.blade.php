<!-- resources/views/your_view.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="">
        <div class="card-header d-flex justify-content-between">
        </div>
        <h2>Peminjaman Selesai</h2>
        {{-- "idtransaksi", "idbuku", "denda", "tgl_kembali", "idpetugas", "nama", "email", "password" --}}
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>ID Buku</th>
                    <th>Denda</th>
                    <th>Tanggal Kembali</th>
                    <th>Petugas</th>
                    <th>Judul</th>
                    <th>ISBN</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peminjamanSelesai as $key => $item)
                    <tr>
                        <td>{{ $item->idtransaksi }}</td>
                        <td>{{ $item->idbuku }}</td>
                        <td>{{ $item->denda }}</td>
                        <td>{{ $item->tgl_kembali }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->judul }}</td>
                        <td>{{ $item->isbn }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <h2>Peminjaman Berlangsung</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>ID Buku</th>
                    <th>Denda</th>
                    <th>Tanggal Kembali</th>
                    <th>Petugas</th>
                    <th>Judul</th>
                    <th>ISBN</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peminjamanBerlangsung as $key => $item)
                    <tr>
                        <td>{{ $item->idtransaksi }}</td>
                        <td>{{ $item->idbuku }}</td>
                        <td>{{ $item->denda }}</td>
                        <td>{{ $item->tgl_kembali }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->judul }}</td>
                        <td>{{ $item->isbn }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <h2>Peminjaman Terlambat</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Denda</th>
                    <th>Tanggal Pinjam</th>
                    <th>Anggota</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peminjamanTerlambat as $key => $item)
                    <tr>
                        <td>{{ $item->denda }}</td>
                        <td>{{ $item->tgl_pinjam }}</td>
                        <td>{{ $item->nama }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
