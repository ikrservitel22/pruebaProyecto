@extends('layouts.app')

@section('Button')
    <button onclick="history.back()" class="btn border btn-dark">Volver</button>
@endsection

@php
    $hideFooter = true;// oculta el footer
@endphp 

@section('content')

<div class="container mt-4">

    <h2 class="text-center mb-4">Dashboard</h2>

    <!-- TARJETAS -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white p-3">
                <h5>Usuarios</h5>
                <h2>25</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white p-3">
                <h5>Eventos</h5>
                <h2>10</h2>
            </div>
        </div>
    </div>

    <!-- GRAFICAS -->
    <div class="row">
        <div class="col-md-6">
            <div class="card bg-secondary text-dark p-3">
                <h5>Eventos por día</h5>
                <canvas id="grafica1"></canvas>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card bg-dark text-white p-3">
                <h5>Tipos de eventos</h5>
                <canvas id="grafica2"></canvas>
            </div>
        </div>
    </div>

</div>

    <!-- SECCIÓN DE FESTIVOS (INTEGRACIÓN) -->
    <div class="row">
        <div class="col-12">
            <div class="card p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>Calendario de Festivos</h5>
                    @if(session('success'))
                        <div class="alert alert-success py-1 px-3 m-0">{{ session('success') }}</div>
                    @endif
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Día</th>
                                <th>Mes</th>
                                <th>Descripción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($festivos as $f)
                            <tr>
                                <td>{{ $f->dia }}</td>
                                <td>{{ $f->mes }}</td>
                                <td>{{ $f->descripcion }}</td>
                                <td>
                                    <!-- Botón que activa el formulario de edición -->
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditar{{ $loop->index }}">
                                        Editar
                                    </button>
                                </td>
                            </tr>

                            <!-- MODAL PARA CADA FESTIVO -->
                            <div class="modal fade" id="modalEditar{{ $loop->index }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ url('/Festivos/update') }}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title">Editar Festivo</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Campo oculto para el ID si lo tienes, o usas los campos actuales -->
                                                <div class="mb-3">
                                                    <label class="form-label">Día</label>
                                                    <input type="number" name="dia" class="form-control" value="{{ $f->dia }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Mes</label>
                                                    <input type="number" name="mes" class="form-control" value="{{ $f->mes }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Descripción</label>
                                                    <input type="text" name="descripcion" class="form-control" value="{{ $f->descripcion }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// GRAFICA 1 (línea)
const ctx1 = document.getElementById('grafica1').getContext('2d');

new Chart(ctx1, {
    type: 'line',
    data: {
        labels: @json($labels),
        datasets: [{
            label: 'Eventos',
            data: @json($data),

            //  colores
            borderColor: '#fd150d',
            backgroundColor: 'rgba(253, 241, 13, 0.2)',

            //  estilo
            borderWidth: 3,
            tension: 0.4,
            fill: true, // relleno debajo de la línea

            //  puntos
            pointBackgroundColor: '#00ff26',
            pointBorderColor: '#00ff26',
            pointRadius: 5,
            pointHoverRadius: 30
        }]
    },

    // ⚙️ TODO lo visual va aquí
    options: {
        responsive: true,

        plugins: {
            legend: {
                labels: {
                    color: '#ffffff'
                }
            },
            title: {
                display: true,
                text: 'Eventos por día',
                color: 'white',
                font: {
                    size: 18
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Eventos: ' + context.raw;
                    }
                }
            }
        },

        scales: {
            x: {
                ticks: {
                    color: 'white'
                },
                grid: {
                    color: 'rgba(255, 0, 0, 0.86)'
                }
            },
            y: {
                beginAtZero: true,
                ticks: {
                    color: 'white'
                },
                grid: {
                    color: 'rgba(21, 255, 0, 0.76)'
                }
            }
        }
    }
});

// GRAFICA 2 (pastel)
const ctx2 = document.getElementById('grafica2').getContext('2d');

new Chart(ctx2, {
    type: 'pie',
    data: {
        labels: ['Reunión', 'Clase', 'Otro'],
        datasets: [{
            data: [60, 40, 100],

            // 🎨 colores de cada sección
            backgroundColor: [
                '#ff3700',
                '#00ffdd',
                '#ee00ff'
            ],

            // borde entre secciones
            borderColor: '#000000',
            borderWidth: 5
        }]
    },

    options: {
        responsive: true,

        plugins: {
            legend: {
                position: 'left',
                labels: {
                    color: '#00ffee',
                    font: {
                        size: 25
                    }
                }
            },

            title: {
                display: true,
                text: 'Tipos de eventos',
                color: 'white',
                font: {
                    size: 18
                }
            },

            tooltip: {
                callbacks: {
                    label: function(context) {
                        let total = context.dataset.data.reduce((a, b) => a + b, 0);
                        let valor = context.raw;
                        let porcentaje = ((valor / total) * 100).toFixed(1);

                        return `${context.label}: ${valor} (${porcentaje}%)`;
                    }
                }
            }
        }
    }
});
</script>

@endsection