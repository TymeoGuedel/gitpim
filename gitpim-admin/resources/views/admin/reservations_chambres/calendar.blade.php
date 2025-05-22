@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10">
    <h1 class="text-2xl font-bold mb-6">Calendrier des réservations 🗓️</h1>

    <!-- FullCalendar CSS -->
    <link href="{{ asset('vendor/fullcalendar/main.min.css') }}" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .fc-toolbar-title {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .fc-button {
            background-color: #3b82f6;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
            margin: 2px;
        }
        .fc-button:hover {
            background-color: #2563eb;
        }
        .fc-event {
            background-color: #10b981 !important;
            border: none;
            padding: 4px 6px;
            font-size: 0.9rem;
        }
    </style>

    <!-- Calendrier -->
    <div id="calendar"
         style="max-width: 1000px; margin: 30px auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); min-height: 600px;">
    </div>

    <!-- MODALE Bootstrap -->
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
            <a id="btn-activity" class="btn btn-success">Ajouter une activité</a>
            <a id="btn-delete" class="btn btn-danger">Supprimer</a>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- FullCalendar & Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let calendarEl = document.getElementById('calendar');

    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'fr',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,listWeek'
        },
        events: {!! json_encode($events) !!},
        eventClick: function(info) {
            info.jsEvent.preventDefault();

            const event = info.event;
            info.el.style.cursor = 'pointer';

            document.getElementById('res-id').innerText = event.id;
            document.getElementById('res-title').innerText = event.title;
            document.getElementById('res-start').innerText = event.startStr;
            document.getElementById('res-end').innerText = event.endStr;

            document.getElementById('btn-edit').href = `/admin/reservations_chambres/${event.id}/edit`;
            document.getElementById('btn-activity').href = `/admin/reservations_repas/create?reservation_chambre_id=${event.id}`;
            document.getElementById('btn-delete').href = `/admin/reservations_chambres/${event.id}`;

            new bootstrap.Modal(document.getElementById('reservationModal')).show();
        }
    });

    calendar.render();
});
</script>
@endpush
