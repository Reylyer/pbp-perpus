<!-- resources/views/create/books.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create a New Book</h2>
        <form action="{{ route('books.doCreate') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" class="form-control" id="author" name="author" required>
            </div>

            <div class="form-group">
                <label for="isbn">ISBN:</label>
                <input type="text" class="form-control" id="isbn" name="isbn" required>
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" class="form-control" id="price" name="price" required>
            </div>

            <div class="form-group">
                <label for="stock">Stock:</label>
                <input type="text" class="form-control" id="stock" name="stock" required>
            </div>

            <div class="form-group">
                <label for="category">Category:</label>
                <select class="form-control" id="category" name="category_id" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Create Book</button>
            <a href="{{ route('books.list') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
