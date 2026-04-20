<div id="sidebar" class="position-fixed start-0 bg-secondary text-white d-flex flex-column p-3 shadow" style="width: 250px; overflow-y: auto; z-index: 1040; top: 0; height: 100vh; left: 0; transform: translateX(-100%); transition: transform .3s;">
    <div class="mb-4 text-center">
        <h5 class="mb-1 border-bottom">Menú</h5>
        <small class="text-muted">CRUD y sesión</small>
    </div>

    @if(session()->has('usuario'))
        @foreach($menu as $seccion)
            <div class="mb-3">
                <h6 class="text-uppercase text-white small mb-2 ">{{ $seccion['titulo'] }}</h6>
                <div class="list-group list-group-flush">
                    @foreach($seccion['items'] as $item)
                        <a href="{{ $item['url'] }}" class="list-group-item list-group-item-action bg-secondary text-white-50 border-secondary">
                            {{ $item['nombre'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="mt-auto pt-3 border-top border-secondary">
            <a href="/logout" class="btn btn-secondary w-100">Cerrar sesión</a>
        </div>
    @else
        <div class="alert alert-secondary py-3 mt-3">
            Inicia sesión para acceder al menú CRUD.
        </div>
    @endif
</div>