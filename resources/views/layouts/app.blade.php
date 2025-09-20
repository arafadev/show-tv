<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SHOW.TV') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        .navbar-brand { font-weight: bold; font-size: 1.5rem; }
        .video-player { width: 100%; max-height: 500px; }
        .episode-card { transition: transform 0.2s; }
        .episode-card:hover { transform: translateY(-5px); }
        .thumbnail { aspect-ratio: 16/9; object-fit: cover; }
        .user-avatar { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; }
        .like-dislike-btn { border: none; background: none; color: #6c757d; }
        .like-dislike-btn.active { color: #007bff; }
        .follow-btn { min-width: 100px; }
        .search-results { margin-top: 2rem; }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
              SHOW.TV
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Search Bar -->
                <form class="d-flex mx-auto" action="{{ route('search') }}" method="GET" style="width: 400px;">
                    <input class="form-control me-2" type="search" name="q" placeholder="Search shows and episodes..." 
                           value="{{ request('q') }}" aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Random Shows
                        </a>
                        <ul class="dropdown-menu" id="randomShowsDropdown">
                        </ul>
                    </li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <img src="{{ auth()->user()->ImageUrl }}" alt="Avatar" class="user-avatar me-2">
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="dropdown-item p-0">
                                    @csrf
                                    <button type="submit" class="btn btn-link dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            loadRandomShows();
        });

        function loadRandomShows() {
            fetch('/random-shows')
                .then(response => response.json())
                .then(data => {
                    const dropdown = $('#randomShowsDropdown');
                    dropdown.empty();
                    
                    data.forEach(show => {
                        dropdown.append(`
                            <li><a class="dropdown-item" href="/series/${show.id}">${show.title}</a></li>
                        `);
                    });
                })
                .catch(() => {
                    $('#randomShowsDropdown').html('<li><span class="dropdown-item-text">No shows available</span></li>');
                });
        }
    </script>

    @stack('scripts')
</body>
</html>