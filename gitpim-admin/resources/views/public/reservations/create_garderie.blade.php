@extends('layouts.app') {{-- ou un layout public si tu en as un --}}

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Réservation Garderie</h2>

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

    <form method="POST" action="{{ route('garderie.store') }}">
        @csrf

        <div id="children-wrapper">
            <div class="child-form mb-4 border p-3 rounded">
                <h5>Enfant #1</h5>

                <div class="mb-3">
                    <label>Nom de l'enfant</label>
                    <input type="text" name="nom_enfant[]" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Âge</label>
                    <input type="number" name="age[]" class="form-control" min="0" max="15" required>
                </div>

                <div class="mb-3">
                    <label>Date</label>
                    <input type="date" name="date[]" class="form-control" required>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label>Heure d'arrivée</label>
                        <input type="time" name="heure_arrivee[]" class="form-control" required>
                    </div>

                    <div class="col mb-3">
                        <label>Heure de départ</label>
                        <input type="time" name="heure_depart[]" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Raison de la présence</label>
                    <input type="text" name="raison_presence[]" class="form-control" required>
                </div>
            </div>
        </div>

        <button type="button" id="add-child" class="btn btn-secondary mb-3">+ Ajouter un enfant</button><br>
        <button type="submit" class="btn btn-primary">Réserver</button>
    </form>
</div>

{{-- Script JS pour dupliquer le bloc enfant --}}
<script>
    let childCount = 1;

    document.getElementById('add-child').addEventListener('click', () => {
        childCount++;
        const wrapper = document.getElementById('children-wrapper');
        const clone = wrapper.firstElementChild.cloneNode(true);

        clone.querySelectorAll('input').forEach(input => input.value = '');
        clone.querySelector('h5').textContent = `Enfant #${childCount}`;
        wrapper.appendChild(clone);
    });
</script>
@endsection
