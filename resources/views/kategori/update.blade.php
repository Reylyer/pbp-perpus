<!-- resources/views/update.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Book</h2>
        <form action="{{ route('books.doUpdate', ['id' => $book->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $book->title }}">
            </div>

            <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" class="form-control" id="author" name="author" value="{{ $book->author }}">
            </div>

            <div class="form-group">
                <label for="isbn">ISBN:</label>
                <input type="text" class="form-control" id="isbn" name="isbn" value="{{ $book->isbn }}">
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" class="form-control" id="price" name="price" value="{{ $book->price }}">
            </div>

            <div class="form-group">
                <label for="stock">Stock:</label>
                <input type="text" class="form-control" id="stock" name="stock" value="{{ $book->stock }}">
            </div>

            <div class="form-group">
                <label for="category">Category:</label>
                <select class="form-control" id="category" name="category_id">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $book->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('books.list') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
