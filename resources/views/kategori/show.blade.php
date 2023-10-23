<!-- resources/views/show.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Book Details</h2>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $book->title }}</h5>
                <p class="card-text"><strong>Author:</strong> {{ $book->author }}</p>
                <p class="card-text"><strong>ISBN:</strong> {{ $book->isbn }}</p>
                <p class="card-text"><strong>Price:</strong> ${{ $book->price }}</p>
                <p class="card-text"><strong>Stock:</strong> {{ $book->stock }}</p>
                <p class="card-text"><strong>Category:</strong> {{ $book->category }}</p>

                <h3>Book Reviews</h3>
                <ul>
                    @forelse($reviews as $review)
                        <li>{{ $review->review }}</li>
                    @empty
                        <li>No reviews available for this book.</li>
                    @endforelse
                </ul>

                <a href="{{ route('books.list') }}" class="btn btn-primary">Back to List</a>
            </div>
        </div>
    </div>
@endsection
