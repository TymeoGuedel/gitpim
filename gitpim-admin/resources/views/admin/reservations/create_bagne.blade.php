@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-10">
    <h2 class="text-2xl font-bold mb-4">🏛️ Ajouter une visite du bagne</h2>

    <form action="{{ route('admin.reservations_bagne.store') }}" method="POST">
        @csrf
        <input type="hidden" name="reservation_chambre_id" value="{{ request('reservation_chambre_id') }}">

        <label class="block">Date (samedi ou dimanche)</label>
        <input type="date" name="date" class="form-control mb-4" required>

        <label class="block">Horaire</label>
        <select name="horaire" class="form-control mb-4" required>
            <option value="matin">Matin</option>
            <option value="apres-midi">Après-midi</option>
        </select>

        <label class="block">Nombre de personnes</label>
        <input type="number" name="nb_personnes" max="10" class="form-control mb-4" required>

        <button class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection
