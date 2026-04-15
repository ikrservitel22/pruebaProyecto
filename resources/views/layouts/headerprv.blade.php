    <nav class="navbar navbar-expand-lg bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand text-light" href="/">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @if(session()->has('usuario'))
                    <li class="nav-item">
                        <a class="nav-link text-light" href="/inputtt">input list</a>
                    </li>
                @endif
                <li class="nav-item">
                <a class="nav-link text-light" href="https://www.youtube.com/watch?v=LbwZCALNfb8&list=RDLbwZCALNfb8&start_radio=1">youtube</a>
                </li>
            </ul>
            <form class="d-flex position-absolute start-50 translate-middle-x w-50" method="GET" action="/buscar">
                <input class="form-control me-2" type="search" name="q" placeholder="Buscar usuario..." />
                <button class="btn btn-outline-light" type="submit">Buscar</button>
            </form>
            </div>
            <div class="ms-auto d-flex gap-2">
                @hasSection('Button')
                    @yield('Button')
                @endif

                @hasSection('Button2')
                    @yield('Button2')
                @endif

            </div>
        </div>
    </nav>