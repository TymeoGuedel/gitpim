@extends('admin.layouts.app')

@section('title', 'Nouvelle réservation')
@section('header', 'Créer une nouvelle réservation')

@section('content')
<form method="POST" action="{{ route('admin.reservations.store') }}">
    @csrf

    {{-- Alertes --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 🏠 Sélection chambre --}}
    <div class="card mb-4">
        <div class="card-header">🏠 Sélection chambre</div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Type de bungalow</label>
                <select class="form-select" name="type_bungalow" id="type_bungalow" required>
                    <option value="">-- Choisir --</option>
                    <option value="mer">Mer (max 2 pers)</option>
                    <option value="jardin">Jardin (max 4 pers)</option>
                </select>
            </div>

            <div class="row">
                <div class="col">
                    <label>Date d’arrivée</label>
                    <input type="date" name="date_debut" class="form-control" required>
                </div>
                <div class="col">
                    <label>Date de départ</label>
                    <input type="date" name="date_fin" class="form-control" required>
                </div>
            </div>

            <div class="mt-3">
                <label>Nombre de personnes</label>
                <input type="number" name="nb_personnes" id="nb_personnes" class="form-control" min="1" required>
            </div>
        </div>
    </div>

    {{-- 🎯 Activités optionnelles --}}
    <div class="card mb-4">
        <div class="card-header">🎯 Activités optionnelles</div>
        <div class="card-body">

            {{-- 🍽️ Repas --}}
            <div class="form-check form-switch mb-2">
                <input class="form-check-input" type="checkbox" id="with_repas" name="with_repas">
                <label class="form-check-label" for="with_repas">Ajouter un repas</label>
            </div>
            <div id="repas_fields" class="mb-3 d-none">
                <label>Nombre de couverts (max 30)</label>
                <input type="number" name="nb_couverts" class="form-control" min="1" max="30">
            </div>

            {{-- 🐎 Randonnée --}}
            <div class="form-check form-switch mb-2">
                <input class="form-check-input" type="checkbox" id="with_randonnee" name="with_randonnee">
                <label class="form-check-label" for="with_randonnee">Ajouter une randonnée</label>
            </div>
            <div id="rando_fields" class="row mb-3 d-none">
                <div class="col">
                    <label>Nombre de cavaliers (max 8)</label>
                    <input type="number" name="nb_cavaliers" class="form-control" min="1" max="8">
                </div>
                <div class="col">
                    <label>Chevaux (CTRL+clic)</label>
                    <select name="chevaux[]" multiple class="form-select">
                        @foreach($chevaux as $cheval)
                            <option value="{{ $cheval }}">{{ $cheval }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- 🛶 Kayak --}}
            <div class="form-check form-switch mb-2">
                <input class="form-check-input" type="checkbox" id="with_kayak" name="with_kayak">
                <label class="form-check-label" for="with_kayak">Ajouter une sortie kayak</label>
            </div>
            <div id="kayak_fields" class="row mb-3 d-none">
                <div class="col">
                    <label>Type de kayak</label>
                    <select name="type_kayak" class="form-select">
                        <option value="double">Double</option>
                        <option value="simple">Simple</option>
                    </select>
                </div>
                <div class="col">
                    <label>Nombre de personnes (max 8)</label>
                    <input type="number" name="nb_kayak_personnes" class="form-control" min="1" max="8">
                </div>
            </div>

            {{-- 👶 Garderie --}}
            <div class="form-check form-switch mb-2">
                <input class="form-check-input" type="checkbox" id="with_garderie" name="with_garderie">
                <label class="form-check-label" for="with_garderie">Ajouter la garderie</label>
            </div>
            <div id="garderie_fields" class="row mb-3 d-none">
                <div class="col">
                    <label>Nom de l’enfant</label>
                    <input type="text" name="nom_enfant" class="form-control">
                </div>
                <div class="col">
                    <label>Âge</label>
                    <input type="number" name="age_enfant" class="form-control" min="1" max="17">
                </div>
            </div>

            {{-- 🏛️ Bagne --}}
            <div class="form-check form-switch mb-2">
                <input class="form-check-input" type="checkbox" id="with_bagne" name="with_bagne">
                <label class="form-check-label" for="with_bagne">Ajouter visite du bagne</label>
            </div>
            <div id="bagne_fields" class="mb-3 d-none">
                <label>Nombre de personnes (max 10)</label>
                <input type="number" name="nb_bagne" class="form-control" min="1" max="10">
            </div>
        </div>
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-primary">Confirmer la réservation</button>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const toggle = (id, target) => {
        document.getElementById(id).addEventListener('change', function () {
            document.getElementById(target).classList.toggle('d-none', !this.checked);
        });
    };

    toggle('with_repas', 'repas_fields');
    toggle('with_randonnee', 'rando_fields');
    toggle('with_kayak', 'kayak_fields');
    toggle('with_garderie', 'garderie_fields');
    toggle('with_bagne', 'bagne_fields');

    // Limiter nb_personnes selon le type de bungalow
    const type = document.getElementById('type_bungalow');
    const nb = document.getElementById('nb_personnes');
    type.addEventListener('change', () => {
        nb.max = type.value === 'mer' ? 2 : 4;
    });
});
</script>
@endpush
