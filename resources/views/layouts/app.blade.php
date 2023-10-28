<!DOCTYPE html>
<html lang="en">

<head>
    <title>SOT Corporation</title>
    <link rel="favicon" type="image/jpg" href="/favicon.ico" />

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/ajax.js') }}" defer></script>
</head>

<body>
    <div id="app" class="container">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.1/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm sticky-top">
            <div class="container">
                <a class="navbar-brand">
                    SOT Corporation
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse d=flex justify-content-between" id="navbarSupportedContent">
                    @if(Auth::guard('petugas')->check())
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('kategori.list') }}">Kategori</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('buku.list') }}">Buku</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('verifikasi.list') }}">Verifikasi Anggota Baru</a>
                            </li>
                            <!-- Add more navigation items here as needed -->
                        </ul>
                    @elseif(Auth::guard('anggota')->check())
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('kategori.list') }}">Kategori</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('buku.list') }}">Buku</a>
                            </li>
                            <!-- Add more navigation items here as needed -->
                        </ul>
                    @endif
                    
                    

                    

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @if(Auth::guard('petugas')->check() || Auth::guard('anggota')->check())
                            <div class="dropdown">
                                {{-- <a id="navbarDropdown" class="nav-link dropdown-toggle" data-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::guard('anggota')->user()->email ?? Auth::guard('petugas')->user()->email  }}
                                </a> --}}
                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::guard('anggota')->user()->email ?? Auth::guard('petugas')->user()->email  }}
                                </a>
                                

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                    {{-- <form id="logout-form" action="{{ route('auth.doLogout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form> --}}
                                    <a class="dropdown-item" href="{{ route('auth.doLogout') }}">{{ __('Logout') }}</a>
                                </div>
                            </div>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('auth.login') }}" class="btn btn-outline-success" role="button">Masuk</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"></a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>
