<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>@yield('title')</title>
</head>
<body>
    <nav class="navbar navbar-light px-4" style="background-color: #e3f2fd;">
        <a href="{{ route('index') }}" class="navbar-brand">Flix&Chill</a>

        <ul class="nav d-flex justify-content-end">
            @if (Auth::user())
                <li class="nav-item">
                    <a href="{{ route('profile.index') }}" class="nav-link">Profile</a>
                </li>
            
                <li class="nav-item">
                    <form action="{{ route('auth.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link">Logout</button>
                    </form>
                </li>
            @else
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('registration') }}" class="nav-link">Register</a>
                </li>
            @endif
        </ul>
    </nav>

    <div class="container my-4">
        @if (session('success'))
            <div class="alert alert-success text-center" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger text-center" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>