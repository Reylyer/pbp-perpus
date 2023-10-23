<!-- resources/views/your_view.blade.php -->

@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="card-header d-flex justify-content-between">
        </div>
        <h2>{{$model['title']}}</h2>
        <a href="{{ route('kategori.create') }}" class="btn btn-primary">Add</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    {{-- loop model info for column alias --}}
                    @foreach($model['alias'] as $key => $value)
                        <th>{{ $value }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($data['res'] as $item)
                    <tr>
                        {{-- loop data row for contents --}}
                        @foreach($model['alias'] as $key => $value)
                            <td>{{ $item->$key }}</td>
                        @endforeach
                        {{-- <td>{{ $item->isbn }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->author }}</td>
                        <td>{{ $item->category }}</td>
                        <td>{{ $item->stock }}</td>
                        <td>${{ $item->price }}</td> --}}
                        {{-- <td>
                            <a href="{{ route('kategori.show', [$model['id'] => $item[$model['id']]]) }}" class="btn btn-primary">View</a>
                            <a href="{{ route('kategori.update', [$model['id'] => $item[$model['id']]]) }}" class="btn btn-success">Edit</a>
                            <form action="{{ route('kategori.doDelete', [$model['id'] => $item[$model['id']]]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
