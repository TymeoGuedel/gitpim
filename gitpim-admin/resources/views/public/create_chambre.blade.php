<form method="POST" action="{{ route('chambre.store') }}">
    @csrf

    <label for="date_debut">Date d'arrivée :</label>
    <input type="date" name="date_debut" id="date_debut" min="{{ now()->toDateString() }}" required>

    <label for="date_fin">Date de départ :</label>
    <input type="date" name="date_fin" id="date_fin" required>

    <button type="submit">Réserver</button>
</form>

<script>
    const dateDebutInput = document.getElementById('date_debut');
    const dateFinInput = document.getElementById('date_fin');

    const today = new Date().toISOString().split('T')[0];
    dateDebutInput.min = today;

    dateDebutInput.addEventListener('change', function () {
        const selected = this.value;
        dateFinInput.min = selected;
        if (dateFinInput.value < selected) {
            dateFinInput.value = '';
        }
    });
</script>
