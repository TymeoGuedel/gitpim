@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-6">
    <h1 class="text-3xl font-bold mb-6 text-center">Nouvelle réservation de chambre</h1>

    <form action="{{ route('admin.reservations_chambres.store') }}" method="POST">
    @csrf


        <div>
            <label for="date_debut" class="block font-medium">Date d'arrivée</label>
            <input type="date" name="date_debut" class="mt-1 block w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label for="date_fin" class="block font-medium">Date de départ</label>
            <input type="date" name="date_fin" class="mt-1 block w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label for="nb_personnes" class="block font-medium">Nombre de personnes</label>
            <input type="number" name="nb_personnes" id="nb_personnes" class="mt-1 block w-full border rounded px-3 py-2" required>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label for="nb_bungalows_mer" class="block font-medium">Bungalows mer</label>
                <input type="number" name="nb_bungalows_mer" id="nb_bungalows_mer" class="mt-1 block w-full border rounded px-3 py-2" min="0" max="5">
            </div>

            <div>
                <label for="nb_bungalows_jardin" class="block font-medium">Bungalows jardin</label>
                <input type="number" name="nb_bungalows_jardin" id="nb_bungalows_jardin" class="mt-1 block w-full border rounded px-3 py-2" min="0" max="10">
            </div>
        </div>

        <div class="flex items-center justify-between mt-6">
            <button type="button" id="auto-fill" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded">
                Répartition automatique
            </button>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded">
                Créer la réservation
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('auto-fill').addEventListener('click', function () {
        let nb = parseInt(document.getElementById('nb_personnes').value);
        let bestJardin = 0;
        let bestMer = 0;
        let minBungalows = Infinity;

        for (let jardin = 0; jardin <= 10; jardin++) {
            for (let mer = 0; mer <= 5; mer++) {
                let places = (jardin * 4) + (mer * 2);

                if (places >= nb) {
                    let totalBungalows = jardin + mer;

                    if (totalBungalows < minBungalows) {
                        minBungalows = totalBungalows;
                        bestJardin = jardin;
                        bestMer = mer;
                    }
                }
            }
        }

        if (minBungalows !== Infinity) {
            document.getElementById('nb_bungalows_jardin').value = bestJardin;
            document.getElementById('nb_bungalows_mer').value = bestMer;
        } else {
            alert("Impossible de loger ce groupe avec les bungalows disponibles.");
        }
    });
</script>
@endsection
