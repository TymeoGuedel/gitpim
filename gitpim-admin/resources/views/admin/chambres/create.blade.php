@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-10">
        <h1 class="text-2xl font-bold mb-6">Ajouter une chambre</h1>

        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 p-4 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.chambres.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="type" class="block font-medium">Type de chambre :</label>
                <select name="type" id="type" class="w-full border rounded px-3 py-2">
                    <option value="mer">Mer</option>
                    <option value="jardin">Jardin</option>
                </select>
            </div>

            <div>
                <label for="capacite" class="block font-medium">Capacité :</label>
                <input type="number" name="capacite" id="capacite" class="w-full border rounded px-3 py-2" min="1" required>
            </div>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Enregistrer
            </button>
        </form>
    </div>
@endsection
