@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-10">
    <h2 class="text-2xl font-bold mb-4">🐎 Ajouter une randonnée</h2>

    <form action="{{ route('admin.reservations_randonnees.store') }}" method="POST">
        @csrf
        <input type="hidden" name="reservation_chambre_id" value="{{ request('reservation_chambre_id') }}">

        <label class="block">Date</label>
        <input type="date" name="date" class="form-control mb-4" required>

        <label class="block">Nombre de cavaliers (max 8)</label>
        <input type="number" name="nb_cavaliers" max="8" class="form-control mb-4" required>

        <label class="block">Chevaux (séparés par virgule)</label>
        <input type="text" name="chevaux" class="form-control mb-4">

        <button class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection
