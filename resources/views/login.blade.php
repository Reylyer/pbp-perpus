@extends('layouts.auth')

@section('content')
    <div class="" style="margin-top: 25vh; margin-bottom: 25vh;">
        <h1 class="text-center mb-4">SOT Corp Library</h1>
        <div class="card mx-auto" style="width: 75%">
            <div class="card-header">Login</div>
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
                    <br>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" value="">
                    </div>
                    <br>
                    <div class="d-flex justify-content-center">
                        <p>Belum memiliki akun? <a href="{{ route('auth.register') }}"
                            class=class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
                            Buat akun</a>
                        </p>
                    </div>
                    <div class="hstack gap-2 justify-content-center">
                        <button type="submit" class="btn btn-success w-25" name="submit" value="submit">Login</button>
                        <a href="{{ route('buku.list') }}" class="btn btn-outline-secondary w-25" role="button">Kembali</a>
                    </div>
                </form>

            </div>
        </div>
    </div>


@endsection
