<!-- resources/views/your_view.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="">
        <h2>Peminjaman Berlangsung</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>No KTP</th>
                    <th>Peminjam</th>
                    <th>ISBN</th>
                    <th>Judul</th>
                    <th>Tanggal pinjam</th>
                    <th>Denda</th>
                    <th>Petugas</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($peminjaman as $p)
                    <tr>
                        <td>{{ $p->idtransaksi }}</td>
                        <td>{{ $p->noktp }}</td>
                        <td>{{ $p->nama_peminjam }}</td>
                        <td>{{ $p->isbn }}</td>
                        <td>{{ $p->judul }}</td>
                        <td>{{ $p->tgl_pinjam }}</td>
                        <td>{{ $p->denda }}</td>
                        <td>{{ $p->nama_petugas }}</td>
                        <td>
                            <a href="{{ route('transaksi.mengembalikan',
                                            ['idtransaksi' => $p->idtransaksi,
                                             'denda' => $p->denda]) }}"
                                class="btn btn-primary">Setujui</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
