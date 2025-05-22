@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10">
    <h1 class="text-2xl font-bold mb-6">Réservations de chambres 🛏️</h1>

 <a href="{{ route('admin.reservations_chambres.create') }}" class="btn btn-success">
    + Créer une nouvelle réservation
</a>


    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($reservations->count())
        <table class="min-w-full bg-white border border-gray-300 rounded shadow">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Dates</th>
                    <th class="px-4 py-2">Nb personnes</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $r)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $r->id }}</td>
                        <td class="px-4 py-2">{{ $r->date_debut }} → {{ $r->date_fin }}</td>
                        <td class="px-4 py-2">{{ $r->nb_personnes }}</td>
                        <td class="px-4 py-2 flex gap-2">
                            <a href="{{ route('admin.reservations_chambres.edit', $r->id) }}" class="bg-yellow-400 px-3 py-1 text-white rounded hover:bg-yellow-500">✏️</a>
                            <form method="POST" action="{{ route('admin.reservations_chambres.destroy', $r->id) }}" onsubmit="return confirm('Supprimer cette réservation ?')">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-600 px-3 py-1 text-white rounded hover:bg-red-700">❌</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Aucune réservation enregistrée.</p>
    @endif
</div>
@endsection
