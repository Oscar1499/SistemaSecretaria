@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Panel de Control</h1>
@endsection

@section('content')
    <div class="container-fluid">
       
        <div class="row">
      
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $totalLibros }}</h3>
                        <p>Total de Libros</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <a href="{{ route('libros.index') }}" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

           
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $totalActas }}</h3>
                        <p>Total de Actas</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <a href="{{ route('actas.index') }}" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

          
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $totalAcuerdos }}</h3>
                        <p>Total de Acuerdos</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <a href="{{ route('acuerdos.index') }}" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

       
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $totalPersonal }}</h3>
                        <p>Total de Personal</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="{{ route('personal.index') }}" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

      
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Gráfica de Libros Registrados</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="librosChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Gráfica de Acuerdos por Año</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="acuerdosChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    
    const librosChartCtx = document.getElementById('librosChart').getContext('2d');
    new Chart(librosChartCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($librosLabels) !!},
            datasets: [{
                label: 'Libros Registrados',
                data: {!! json_encode($librosData) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });


    const acuerdosChartCtx = document.getElementById('acuerdosChart').getContext('2d');
    new Chart(acuerdosChartCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($acuerdosLabels) !!},
            datasets: [{
                label: 'Acuerdos por Año',
                data: {!! json_encode($acuerdosData) !!},
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection

