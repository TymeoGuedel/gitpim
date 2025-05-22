@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-10">
    <h2 class="text-2xl font-bold mb-4">🍽️ Ajouter un repas</h2>

    <form action="{{ route('admin.reservations_repas.store') }}" method="POST">
        @csrf
        <input type="hidden" name="reservation_chambre_id" value="{{ request('reservation_chambre_id') }}">

        <label class="block">Nombre de couverts (max 30)</label>
        <input type="number" name="nb_couverts" max="30" class="form-control mb-4" required>

        <label class="block">Date</label>
        <input type="date" name="date" class="form-control mb-4" required>

        <label class="block">Horaire</label>
        <input type="time" name="horaire" class="form-control mb-4" required>

        <button class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection
