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
                        <th>Nama</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>
                                {{-- fix missing parameter idkategori --}}
                                <a href="{{ route('kategori.show', ['idkategori' => $item->idkategori]) }}"
                                    class="btn btn-primary">View</a>
                                <a href="{{ route('kategori.update', ['idkategori' => $item->idkategori]) }}"
                                    class="btn btn-success">Edit</a>
                                <form action="{{ route('kategori.doDelete', ['idkategori' => $item->idkategori]) }}"
                                    method="POST" style="display:inline;">
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
    </div>
@endsection
