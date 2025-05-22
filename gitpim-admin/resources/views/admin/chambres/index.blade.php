@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-10">
        <h1 class="text-2xl font-bold mb-4 text-red-600">TEST AFFICHAGE CHAMBRES</h1>
        <a href="{{ route('admin.chambres.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
    ➕ Ajouter une chambre
</a>


        <p class="text-green-600 mb-6">Chambres détectées : {{ $chambres->count() }}</p>

        <table class="min-w-full bg-white border border-gray-300 rounded shadow">
    <thead class="bg-gray-100">
        <tr>
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">Type</th>
            <th class="px-4 py-2">Capacité</th>
            <th class="px-4 py-2">Disponible</th>
            <th class="px-4 py-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($chambres as $chambre)
            <tr class="border-t">
                <td class="px-4 py-2">{{ $chambre->id }}</td>
                <td class="px-4 py-2">{{ ucfirst($chambre->type) }}</td>
                <td class="px-4 py-2">{{ $chambre->capacite }}</td>
                <td class="px-4 py-2">{{ $chambre->disponible ? 'Oui' : 'Non' }}</td>
                <td class="px-4 py-2 flex gap-2">
                    <a href="{{ route('admin.chambres.edit', $chambre->id) }}" class="px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500">
                        ✏️ Modifier
                    </a>

                    <form action="{{ route('admin.chambres.destroy', $chambre->id) }}" method="POST" onsubmit="return confirm('Supprimer cette chambre ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                            ❌ Supprimer
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

    </div>
@endsection
