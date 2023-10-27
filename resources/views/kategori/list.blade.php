<!-- resources/views/your_view.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="">
        <div class="card-header d-flex justify-content-between">
        </div>
        <h2>CRUD Table</h2>
        <a href="{{ route('kategori.create') }}" class="btn btn-primary">Add</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $key => $item)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>
                            {{-- fix missing parameter idkategori --}}
                            <a href="{{ route('kategori.show', ['idkategori' => $item->idkategori]) }}" class="btn btn-primary">View</a>
                            <a href="{{ route('kategori.update', ['idkategori' => $item->idkategori]) }}" class="btn btn-success">Edit</a>
                            <form action="{{ route('kategori.doDelete', ['idkategori' => $item->idkategori]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
