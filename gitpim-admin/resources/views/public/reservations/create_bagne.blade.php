@extends('layouts.app') {{-- ou layouts.public si tu as une version pour le front --}}

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Réserver une visite du bagne</h2>

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

    <form action="{{ route('bagne.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nom_client" class="form-label">Nom complet</label>
            <input type="text" name="nom_client" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email_client" class="form-label">Adresse e-mail</label>
            <input type="email" name="email_client" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Date (Samedi ou Dimanche)</label>
            <input type="date" name="date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="horaire" class="form-label">Horaire de visite</label>
            <select name="horaire" class="form-select" required>
                <option value="">-- Choisissez une session --</option>
                <option value="matin">Matin (10h - 11h30)</option>
                <option value="apres-midi">Après-midi (14h - 15h30)</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="nb_personnes" class="form-label">Nombre de personnes</label>
            <input type="number" name="nb_personnes" min="1" max="10" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Réserver</button>
    </form>
</div>
@endsection
