@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card mt-5">
        <div class="card-header">
            {{ $model['title'] }}
        </div>
        <div class="card-body">
            <!-- Search Bar -->
            <form action="{{ route('kategori.list') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ $data['searchTerm'] }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Filter</button>
                    </div>
                </div>
            </form>

            <table class="table table-striped">
                <thead>
                    <tr>
                        @foreach($model['alias'] as $key => $value)
                            <th>
                                <a href="{{ route('kategori.list', ['orderBy' => $key, 'order' => $data['orderBy'] == $key && $data['order'] == 'asc' ? 'desc' : 'asc']) }}">
                                    {{ $value }}
                                    @if($data['orderBy'] == $key)
                                        @if($data['order'] == 'asc')
                                            &uarr;
                                        @else
                                            &darr;
                                        @endif
                                    @endif
                                </a>
                            </th>
                        @endforeach
                        <!-- Add other columns as needed -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['res'] as $item)
                        <tr>
                            @foreach($model['alias'] as $key => $value)
                                <td>{{ $item->$key }}</td>
                            @endforeach
                            <!-- Add other columns as needed -->
                            <td>
                                <a href="{{ route('kategori.show', $item->{$model['id']}) }}" class="btn btn-primary">View</a>
                                <a href="{{ route('kategori.update', $item->{$model['id']}) }}" class="btn btn-success">Edit</a>
                                <form action="{{ route('kategori.doDelete', $item->{$model['id']}) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="pagination">
                @for($i = 1; $i <= ceil($data['totalCount'] / $data['limit']); $i++)
                    <a href="{{ route('kategori.list', ['page' => $i, 'limit' => $data['limit'], 'orderBy' => $data['orderBy'], 'order' => $data['order'], 'search' => $data['searchTerm']]) }}"
                        class="btn btn-outline-primary {{ $data['page'] == $i ? 'active' : '' }}">
                        {{ $i }}
                    </a>
                @endfor
            </div>
            <div>Total Rows: {{ $data['totalCount'] }}</div>
        </div>
    </div>
</div>
@endsection
