@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card mt-4">
    <div class="card-header">Login Form</div>
    <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form method="POST" autocomplete="on" action="">
        @csrf
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" value="">
        </div>
        <br>
        <div>
            <button type="submit" class="btn btn-primary" name="submit" value="submit">Login</button>
            <a href="{{ route('auth.register') }}" class="btn btn-primary">Buat akun</a>
        </div>
        </form>

    </div>
    </div>
</div>


@endsection