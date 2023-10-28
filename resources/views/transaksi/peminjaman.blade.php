<!-- resources/views/create/kategori.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h2>Form peminjaman</h2>
        <form action="{{ route('transaksi.pinjam') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="noktp">Peminjam</label>
                <select class="form-control" name="noktp">
                @foreach ($peminjam as $p)
                    <option value="{{ $p->noktp }}"> {{ $p->noktp . " - ". $p->nama }}</option>
                @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="idbuku">Buku yang dipinjam</label>
                <select class="form-control" name="idbuku">
                @foreach ($buku as $b)
                    <option value="{{ $b->idbuku }}"> {{ $b->isbn . " - " . $b->judul }}</option>
                @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{ route('transaksi.list') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
