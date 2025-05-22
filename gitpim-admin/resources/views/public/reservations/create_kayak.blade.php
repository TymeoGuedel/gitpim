@extends('layouts.app') {{-- ou layouts.public selon ta structure --}}

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Réservation Kayak</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kayak.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nom_client" class="form-label">Nom complet</label>
            <input type="text" name="nom_client" id="nom_client" class="form-control" value="{{ old('nom_client') }}" required>
        </div>

        <div class="mb-3">
            <label for="email_client" class="form-label">Adresse email</label>
            <input type="email" name="email_client" id="email_client" class="form-control" value="{{ old('email_client') }}" required>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Date souhaitée</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ old('date') }}" required>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="heure_debut" class="form-label">Heure de début</label>
                <input type="time" name="heure_debut" id="heure_debut" class="form-control" min="09:00" max="16:00" value="{{ old('heure_debut') }}" required>
            </div>
            <div class="col">
                <label for="heure_fin" class="form-label">Heure de fin</label>
                <input type="time" name="heure_fin" id="heure_fin" class="form-control" min="09:00" max="16:00" value="{{ old('heure_fin') }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="type_kayak" class="form-label">Type de kayak</label>
            <select name="type_kayak" id="type_kayak" class="form-select" required>
                <option value="">-- Choisir un type --</option>
                <option value="simple" {{ old('type_kayak') == 'simple' ? 'selected' : '' }}>Kayak simple (1 personne)</option>
                <option value="double" {{ old('type_kayak') == 'double' ? 'selected' : '' }}>Kayak double (2 personnes)</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="nb_personnes" class="form-label">Nombre de personnes</label>
            <input type="number" name="nb_personnes" id="nb_personnes" class="form-control" min="1" max="8" value="{{ old('nb_personnes') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Réserver</button>
    </form>
</div>
@endsection
