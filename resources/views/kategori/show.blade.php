<!-- resources/views/show.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Kategori Details</h2>
        <div class="card">
            <div class="card-body">
                <p class="card-text"><strong>Nama: </strong> {{ $data->nama }}</p>


                <a href="{{ route('kategori.list') }}" class="btn btn-primary">Back to List</a>
            </div>
        </div>
    </div>
@endsection
