<!-- resources/views/your_view.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="">
        <div class="card-header d-flex justify-content-between">
        </div>
        <h2>Detail Transaksi</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Transaksi</th>
                    <th>ID Buku</th>
                    <th>Denda</th>
                    <th>Tanggal Kembali</th>
                    <th>ID Petugas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $key => $item)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $item->idtransaksi }}</td>
                        <td>{{ $item->idbuku }}</td>
                        <td>{{ $item->denda }}</td>
                        <td>{{ $item->tgl_kembali }}</td>
                        <td>{{ $item->idpetugas }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
