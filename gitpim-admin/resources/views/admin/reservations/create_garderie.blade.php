@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-10">
    <h2 class="text-2xl font-bold mb-4">👶 Ajouter à la garderie</h2>

    <form action="{{ route('admin.reservations_garderie.store') }}" method="POST">
        @csrf
        <input type="hidden" name="reservation_chambre_id" value="{{ request('reservation_chambre_id') }}">

        <label class="block">Nom de l’enfant</label>
        <input type="text" name="nom_enfant" class="form-control mb-4" required>

        <label class="block">Âge</label>
        <input type="number" name="age" class="form-control mb-4" min="0" max="15" required>

        <label class="block">Date</label>
        <input type="date" name="date" class="form-control mb-4" required>

        <label class="block">Heure d’arrivée</label>
        <input type="time" name="heure_arrivee" class="form-control mb-4" required>

        <label class="block">Heure de départ</label>
        <input type="time" name="heure_depart" class="form-control mb-4" required>

        <label class="block">Raison de la présence</label>
        <input type="text" name="raison_presence" class="form-control mb-4">

        <button class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection
