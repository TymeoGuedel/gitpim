@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">📋 Liste des réservations de chambres</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Date d'arrivée</th>
                <th>Date de départ</th>
                <th>Personnes</th>
                <th>Bungalows Mer</th>
                <th>Bungalows Jardin</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->id }}</td>
                    <td>{{ $reservation->date_debut }}</td>
                    <td>{{ $reservation->date_fin }}</td>
                    <td>{{ $reservation->nb_personnes }}</td>
                    <td>{{ $reservation->nb_bungalows_mer }}</td>
                    <td>{{ $reservation->nb_bungalows_jardin }}</td>
                    <td>
                        <a href="{{ route('admin.reservations_chambres.edit', $reservation) }}" class="btn btn-sm btn-outline-primary">✏️</a>
                        <form action="{{ route('admin.reservations_chambres.destroy', $reservation) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Supprimer cette réservation ?')" class="btn btn-sm btn-outline-danger">🗑️</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Aucune réservation enregistrée pour le moment.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
