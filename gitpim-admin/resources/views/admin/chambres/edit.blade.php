@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-10">
        <h1 class="text-2xl font-bold mb-6">Modifier la chambre</h1>

        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 p-4 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.chambres.update', $chambre->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="type" class="block font-medium">Type :</label>
                <select name="type" id="type" class="w-full border rounded px-3 py-2">
                    <option value="mer" {{ $chambre->type == 'mer' ? 'selected' : '' }}>Mer</option>
                    <option value="jardin" {{ $chambre->type == 'jardin' ? 'selected' : '' }}>Jardin</option>
                </select>
            </div>

            <div>
                <label for="capacite" class="block font-medium">Capacité :</label>
                <input type="number" name="capacite" id="capacite" class="w-full border rounded px-3 py-2" value="{{ $chambre->capacite }}" required>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Enregistrer les modifications
            </button>
        </form>
    </div>
@endsection
