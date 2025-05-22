@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-6">
    <h1 class="text-2xl font-bold mb-6 text-center">
        Activités pour la réservation #{{ $reservation->id }}
    </h1>

    <div class="bg-white shadow p-6 rounded-lg mb-6 space-y-2 text-sm text-gray-700">
        <p><strong>Dates :</strong> du {{ $reservation->date_debut }} au {{ $reservation->date_fin }}</p>
        <p><strong>Nombre de personnes :</strong> {{ $reservation->nb_personnes }}</p>
        <p><strong>Bungalows mer :</strong> {{ $reservation->nb_bungalows_mer }}</p>
        <p><strong>Bungalows jardin :</strong> {{ $reservation->nb_bungalows_jardin }}</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        {{-- 🍽️ Repas --}}
        <a href="{{ route('admin.reservations_repas.create', ['reservation_chambre_id' => $reservation->id]) }}"
           class="block bg-blue-100 hover:bg-blue-200 text-blue-900 font-semibold py-3 px-4 rounded shadow">
            🍽️ Ajouter un repas
        </a>

        {{-- 🐎 Randonnée --}}
        <a href="{{ route('admin.reservations_randonnees.create', ['reservation_chambre_id' => $reservation->id]) }}"
           class="block bg-green-100 hover:bg-green-200 text-green-900 font-semibold py-3 px-4 rounded shadow">
            🐎 Ajouter une randonnée
        </a>

        {{-- 🛶 Kayak --}}
        <a href="{{ route('admin.reservations_kayak.create', ['reservation_chambre_id' => $reservation->id]) }}"
           class="block bg-cyan-100 hover:bg-cyan-200 text-cyan-900 font-semibold py-3 px-4 rounded shadow">
            🛶 Ajouter une sortie kayak
        </a>

        {{-- 👶 Garderie --}}
        <a href="{{ route('admin.reservations_garderie.create', ['reservation_chambre_id' => $reservation->id]) }}"
           class="block bg-yellow-100 hover:bg-yellow-200 text-yellow-900 font-semibold py-3 px-4 rounded shadow">
            👶 Ajouter à la garderie
        </a>

        {{-- 🏛️ Bagne --}}
        <a href="{{ route('admin.reservations_bagne.create', ['reservation_chambre_id' => $reservation->id]) }}"
           class="block bg-red-100 hover:bg-red-200 text-red-900 font-semibold py-3 px-4 rounded shadow">
            🏛️ Ajouter visite du bagne
        </a>
    </div>
</div>
