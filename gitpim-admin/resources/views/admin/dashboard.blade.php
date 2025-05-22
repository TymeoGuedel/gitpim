@extends('admin.layouts.app')

@section('title', 'Tableau de bord')
@section('header', 'Tableau de bord')

@section('content')
<div class="mb-4 text-end">
    <a href="{{ route('admin.reservations.create') }}" class="btn btn-success">
        + Créer une nouvelle réservation
    </a>
</div>

<div class="row mb-4">
    @foreach([
        ['label' => 'Total réservations', 'value' => $stats['total_chambres'], 'class' => 'primary'],
        ['label' => 'Bungalows Mer', 'value' => $stats['total_mer'], 'class' => 'success'],
        ['label' => 'Bungalows Jardin', 'value' => $stats['total_jardin'], 'class' => 'warning'],
        ['label' => 'Réservations ce mois', 'value' => $stats['mois'], 'class' => 'info'],
    ] as $card)
    
        <div class="col-md-3">
            <div class="card text-white bg-{{ $card['class'] }} mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $card['label'] }}</h5>
                    <p class="card-text fs-3">{{ $card['value'] }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- Calendrier --}}
<div class="card mb-5">
    <div class="card-body">
        <h5 class="card-title mb-3">📅 Calendrier des réservations</h5>
        <div id="calendar" style="min-height: 600px;"></div>
    </div>
</div>

{{-- Modale Bootstrap --}}
<div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="reservationModalLabel">Détail de la réservation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <p><strong>ID :</strong> <span id="res-id"></span></p>
        <p><strong>Début :</strong> <span id="res-start"></span></p>
        <p><strong>Fin :</strong> <span id="res-end"></span></p>
        <p><strong>Détails :</strong> <span id="res-title"></span></p>
      </div>
      <div class="modal-footer">
        <a id="btn-edit" class="btn btn-primary">Modifier</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
{{-- FullCalendar CSS + JS --}}
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'fr',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek'
        },
        events: @json($events),
        eventClick: function(info) {
            const e = info.event;
            document.getElementById('res-id').innerText = e.id;
            document.getElementById('res-title').innerText = e.title;
            document.getElementById('res-start').innerText = e.startStr;
            document.getElementById('res-end').innerText = e.endStr;

            document.getElementById('btn-edit').href = `/admin/reservations_chambres/${e.id}/edit`;

            new bootstrap.Modal(document.getElementById('reservationModal')).show();
        }
    });
    calendar.render();
});
</script>
@endpush
