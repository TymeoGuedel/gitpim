@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10">
    <h1 class="text-2xl font-bold mb-6">Ajouter une table</h1>

    <form action="{{ route('admin.repas.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block font-medium" for="capacite">Capacité :</label>
            <input type="number" name="capacite" id="capacite" required class="w-full border px-3 py-2 rounded">
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Enregistrer
        </button>
    </form>
</div>
@endsection
