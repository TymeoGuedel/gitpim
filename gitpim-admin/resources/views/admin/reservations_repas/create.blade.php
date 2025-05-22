@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10">
    <h1 class="text-2xl font-bold mb-6">Réserver un repas</h1>

    <form action="{{ route('admin.reservations_repas.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block font-medium">Réservation liée :</label>
            <select name="reservation_chambre_id" class="w-full border px-3 py-2 rounded" required>
                <option value="">-- Choisir une réservation --</option>
                @foreach($reservations as $res)
                    <option value="{{ $res->id }}">#{{ $res->id }} | {{ $res->date_debut }} → {{ $res->date_fin }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-medium">Date :</label>
            <input type="date" name="date" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div>
            <label class="block font-medium">Horaire :</label>
            <input type="time" name="horaire" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div>
            <label class="block font-medium">Nombre de couverts :</label>
            <input type="number" name="nb_couverts" min="1" class="w-full border px-3 py-2 rounded" required>
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Réserver
        </button>
    </form>
</div>
@endsection
