<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Task System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Task System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            @auth
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto">
                    @if(auth()->user()->role === 'super-admin')
                    <li class="nav-item"><a class="nav-link" href="{{ route('admins.index') }}">Admins</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('tasks.create') }}">Assign Task</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('tasks.index') }}">Tasks</a></li>
                    @endif
                    @if(auth()->user()->role != 'super-admin')
                    <li class="nav-item"><a class="nav-link" href="{{ route('tasks.my') }}">My Tasks</a></li>
                    @endif
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-link nav-link" type="submit">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
            @endauth
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>