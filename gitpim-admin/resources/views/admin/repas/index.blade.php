@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10">
    <h1 class="text-2xl font-bold mb-6">Tables pour les repas 🍽️</h1>

    <a href="{{ route('admin.repas.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        ➕ Ajouter une table
    </a>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($tables->count())
        <table class="min-w-full bg-white border border-gray-300 rounded shadow">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Capacité</th>
                    <th class="px-4 py-2">Disponible</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tables as $table)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $table->id }}</td>
                        <td class="px-4 py-2">{{ $table->capacite }}</td>
                        <td class="px-4 py-2">{{ $table->disponible ? 'Oui' : 'Non' }}</td>
                        <td class="px-4 py-2 flex gap-2">
                            <a href="{{ route('admin.repas.edit', $table->id) }}" class="bg-yellow-400 px-3 py-1 text-white rounded hover:bg-yellow-500">✏️</a>
                            <form method="POST" action="{{ route('admin.repas.destroy', $table->id) }}" onsubmit="return confirm('Supprimer cette table ?')">
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
        <p>Aucune table enregistrée.</p>
    @endif
</div>
@endsection
