<nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            {{ config('app.name') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#webdiscuss-navbar" aria-controls="webdiscuss-navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="webdiscuss-navbar">
            <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('users.show', Auth::user()) }}">
                                My profile
                            </a>
                            <a class="dropdown-item" href="{{ route('users.stats') }}">
                                WebDiscuss statistics
                            </a>
                            @hasrole('administrator|moderator')
                                <a class="dropdown-item" href="{{ route('dashboard.index') }}">
                                    Dashboard
                                </a>
                                <a class="dropdown-item" href="{{ route('report.index') }}">
                                    Reported posts
                                </a>
                            @endhasrole
                            @hasrole('administrator')
                                <a class="dropdown-item" href="{{ route('forums.create') }}">
                                    Create forum
                                </a>
                                <a class="dropdown-item" href="{{ route('moderators.list') }}">
                                    Manage moderators
                                </a>
                            @endhasrole
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>