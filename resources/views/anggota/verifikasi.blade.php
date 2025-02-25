<!-- resources/views/your_view.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Verifikasi Pendaftaran Anggota Baru</div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Kota</th>
                        <th>Email</th>
                        <th>No Telp</th>
                        <th>File KTP</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td>{{ $item->kota }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->no_telp }}</td>
                            <td>
                                <img src="{{ asset('storage/images/' . $item->file_ktp) }}" class="img-fluid w-25"
                                alt={{ $item->file_ktp }}>
                            </td>
                            @if ($item->status == '0')
                                <td>Belum diverifikasi</td>
                            @endif
                            @if ($item->status == '1')
                                <td>Sudah diverifikasi</td>
                            @endif
                            <td><a href="{{ route('verifikasi.doVerifikasi', ['noktp' => $item->noktp]) }}"><button
                                        class="btn btn-primary btn-sm">Verifikasi</button></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
