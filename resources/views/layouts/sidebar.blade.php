<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="{{route('dashboard')}}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-heading">Pages</li>
        @auth
        @if(auth()->user()->role === 'tester')
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('user') }}">
                <i class="bi bi-card-list"></i>
                <span>User</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('user-task') }}">
                <i class="bi bi-envelope"></i>
                <span>Tasks</span>
            </a>
        </li>
        @endif
        @if(auth()->user()->role === 'super-admin')
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('admins.index') }}">
                <i class="bi bi-person"></i>
                <span>User</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('tasks.create') }}">
                <i class="bi bi-question-circle"></i>
                <span>Assign Task</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('tasks.index') }}">
                <i class="bi bi-envelope"></i>
                <span>Tasks</span>
            </a>
        </li>
        @endif
        @if(auth()->user()->role != 'super-admin')
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('tasks.my') }}">
                <i class="bi bi-card-list"></i>
                <span>My Tasks</span>
            </a>
        </li><!-- End Register Page Nav -->
        @endif
        
        @endauth
    </ul>
</aside>