    <nav id="main-navbar" class="navbar navbar-expand-lg bg-dark" style="transition: margin-left .3s;">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="mx-auto d-flex gap-2 align-items-center">
                <button class="btn btn-outline-light" type="button" onclick="toggleSidebar()">
                    ...
                </button>

                @hasSection('Button')
                    @yield('Button')
                @endif

                @hasSection('Button2')
                    @yield('Button2')
                @endif

            </div>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <form class="d-flex position-absolute start-50 translate-middle-x w-50" method="GET" action="/buscar">
                <input class="form-control me-2" type="search" name="q" placeholder="Buscar usuario..." />
                <button class="btn btn-outline-light" type="submit">Buscar</button>
            </form>
            </div>

        </div>
    </nav>