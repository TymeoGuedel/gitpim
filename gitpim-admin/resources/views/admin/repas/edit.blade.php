@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10">
    <h1 class="text-2xl font-bold mb-6">Modifier la table</h1>

    <form action="{{ route('admin.repas.update', $table->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-medium" for="capacite">Capacité :</label>
            <input type="number" name="capacite" id="capacite" value="{{ $table->capacite }}" required class="w-full border px-3 py-2 rounded">
        </div>

        <div>
            <label class="inline-flex items-center">
                <input type="checkbox" name="disponible" {{ $table->disponible ? 'checked' : '' }}>
                <span class="ml-2">Disponible</span>
            </label>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Mettre à jour
        </button>
    </form>
</div>
@endsection
