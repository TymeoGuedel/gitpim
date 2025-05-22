@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10">
    <h1 class="text-2xl font-bold mb-6">Modifier la réservation</h1>

    <form action="{{ route('admin.reservations_chambres.update', $reservation->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-medium" for="date_debut">Date de début :</label>
            <input type="date" name="date_debut" id="date_debut" value="{{ $reservation->date_debut }}" required class="w-full border px-3 py-2 rounded">
        </div>

        <div>
            <label class="block font-medium" for="date_fin">Date de fin :</label>
            <input type="date" name="date_fin" id="date_fin" value="{{ $reservation->date_fin }}" required class="w-full border px-3 py-2 rounded">
        </div>

        <div>
            <label class="block font-medium" for="nb_personnes">Nombre de personnes :</label>
            <input type="number" name="nb_personnes" id="nb_personnes" value="{{ $reservation->nb_personnes }}" required class="w-full border px-3 py-2 rounded">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Mettre à jour
        </button>
    </form>
</div>
@endsection
