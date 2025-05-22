@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-10">
    <h2 class="text-2xl font-bold mb-4">🛶 Ajouter une sortie kayak</h2>

    <form action="{{ route('admin.reservations_kayak.store') }}" method="POST">
        @csrf
        <input type="hidden" name="reservation_chambre_id" value="{{ request('reservation_chambre_id') }}">

        <label class="block">Date</label>
        <input type="date" name="date" class="form-control mb-4" required>

        <label class="block">Heure de début</label>
        <input type="time" name="heure_debut" class="form-control mb-4" required>

        <label class="block">Heure de fin</label>
        <input type="time" name="heure_fin" class="form-control mb-4" required>

        <label class="block">Type de kayak</label>
        <select name="type_kayak" class="form-control mb-4" required>
            <option value="simple">Simple</option>
            <option value="double">Double</option>
        </select>

        <label class="block">Nombre de personnes</label>
        <input type="number" name="nb_personnes" class="form-control mb-4" required>

        <button class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection
