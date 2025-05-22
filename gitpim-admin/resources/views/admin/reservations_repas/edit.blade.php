@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10">
    <h1 class="text-2xl font-bold mb-6">Modifier la réservation de repas</h1>

    <form action="{{ route('admin.reservations_repas.update', $repa->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-medium">Réservation liée :</label>
            <select name="reservation_chambre_id" class="w-full border px-3 py-2 rounded" required>
                @foreach($reservations as $res)
                    <option value="{{ $res->id }}" {{ $repa->reservation_chambre_id == $res->id ? 'selected' : '' }}>
                        #{{ $res->id }} | {{ $res->date_debut }} → {{ $res->date_fin }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-medium">Date :</label>
            <input type="date" name="date" value="{{ $repa->date }}" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div>
            <label class="block font-medium">Horaire :</label>
            <input type="time" name="horaire" value="{{ $repa->horaire }}" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div>
            <label class="block font-medium">Nombre de couverts :</label>
            <input type="number" name="nb_couverts" value="{{ $repa->nb_couverts }}" min="1" class="w-full border px-3 py-2 rounded" required>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Mettre à jour
        </button>
    </form>
</div>
@endsection
