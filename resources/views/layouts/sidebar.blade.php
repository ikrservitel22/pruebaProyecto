<div class="bg-secondary text-white position-fixed end-0 p-3"
     style="width: 230px; height: d-flex flex-column h-100; top: 56px; overflow-y: auto;">

    <h5 class=" text-center border-bottom pb-2 mb-3">Menú</h5>

    <ul class="list-unstyled ps-0">

        @foreach($menu as $index => $grupo)
            <li class="mb-1">

                <!-- BOTÓN PRINCIPAL -->
                <button class=" btn btn-toggle align-items-center rounded border text-white w-100 text-start"
                        data-bs-toggle="collapse"
                        data-bs-target="#menu-{{ $index }}"
                        aria-expanded="false">

                    {{ $grupo['titulo'] }}
                </button>

                <!-- SUBMENÚ -->
                <div class="collapse" id="menu-{{ $index }}">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">

                        @foreach($grupo['items'] as $item)
                            <li>
                                <a href="{{ $item['url'] }}"
                                   class="text-white text-decoration-none d-block px-3 py-1 rounded hover-menu">
                                    {{ $item['nombre'] }}
                                </a>
                            </li>
                        @endforeach

                    </ul>
                </div>

            </li>
        @endforeach

    </ul>
</div>