<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img src="/img/wifi.png" width="30" height="30" alt="">
            NetLogger
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">

                @if(!request()->is('dashboard'))
                    <li class="nav-item">
                        <a class="nav-link" href="/add/ip">Add your IP</a>
                    </li>
                @endif

                @if(auth()->check())
                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard">Dashboard</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/logout">Logout</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>