@extends('admin.layouts.app')

@section('title', 'Statistiques Globales')
@section('header', 'Statistiques des Activités')

@section('content')
<div class="container">
    <h3 class="mb-4">📊 Statistiques globales par activité</h3>

    <div class="row">
        @foreach($stats as $type => $total)
            <div class="col-md-3 mb-3">
                <div class="card bg-light">
                    <div class="card-body">
                        <h6 class="card-title text-capitalize">{{ $type }}</h6>
                        <div class="progress">
                            <div class="progress-bar bg-info" style="width: 100%">{{ $total }} réservations</div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
<form method="GET" class="row mb-4">
    <div class="col-md-3">
        <label for="from">Du :</label>
        <input type="date" name="from" id="from" class="form-control" value="{{ $from }}">
    </div>
    <div class="col-md-3">
        <label for="to">Au :</label>
        <input type="date" name="to" id="to" class="form-control" value="{{ $to }}">
    </div>
    <div class="col-md-3 align-self-end">
        <button type="submit" class="btn btn-primary">Filtrer</button>
    </div>
</form>


    <hr class="my-5">

    <h4 class="mb-3">📈 Évolution des réservations par jour</h4>
    <canvas id="activitesChart" height="120"></canvas>
</div>
<hr class="my-5">
<h4>🏡 Bungalows utilisés (sur période sélectionnée)</h4>

<div class="mb-3">
    <h6>Mer : {{ $stats['bungalows_mer_utilisés'] }}/{{ $stats['bungalows_mer_total'] }}</h6>
    <div class="progress">
        <div class="progress-bar bg-primary"
             role="progressbar"
             style="width: {{ ($stats['bungalows_mer_utilisés'] / $stats['bungalows_mer_total']) * 100 }}%"
             aria-valuenow="{{ $stats['bungalows_mer_utilisés'] }}"
             aria-valuemin="0"
             aria-valuemax="{{ $stats['bungalows_mer_total'] }}">
            {{ round(($stats['bungalows_mer_utilisés'] / $stats['bungalows_mer_total']) * 100) }}%
        </div>
    </div>
</div>

<div class="mb-3">
    <h6>Jardin : {{ $stats['bungalows_jardin_utilisés'] }}/{{ $stats['bungalows_jardin_total'] }}</h6>
    <div class="progress">
        <div class="progress-bar bg-success"
             role="progressbar"
             style="width: {{ ($stats['bungalows_jardin_utilisés'] / $stats['bungalows_jardin_total']) * 100 }}%"
             aria-valuenow="{{ $stats['bungalows_jardin_utilisés'] }}"
             aria-valuemin="0"
             aria-valuemax="{{ $stats['bungalows_jardin_total'] }}">
            {{ round(($stats['bungalows_jardin_utilisés'] / $stats['bungalows_jardin_total']) * 100) }}%
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('activitesChart').getContext('2d');

    const labels = {!! json_encode($jours->pluck('date')->toArray()) !!};

    const data = {
        labels: labels,
        datasets: [
            {
                label: 'Repas',
                data: {!! json_encode($jours->pluck('repas')) !!},
                borderColor: '#0d6efd',
                tension: 0.3
            },
            {
                label: 'Kayak',
                data: {!! json_encode($jours->pluck('kayak')) !!},
                borderColor: '#198754',
                tension: 0.3
            },
            {
                label: 'Garderie',
                data: {!! json_encode($jours->pluck('garderie')) !!},
                borderColor: '#ffc107',
                tension: 0.3
            },
            {
                label: 'Bagne',
                data: {!! json_encode($jours->pluck('bagne')) !!},
                borderColor: '#dc3545',
                tension: 0.3
            }
        ]
    };

    new Chart(ctx, {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endpush
