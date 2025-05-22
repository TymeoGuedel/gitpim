<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReservationGarderie;
use Illuminate\Support\Carbon;

class ReservationGarderieController extends Controller
{
   public function store(Request $request)
{
    $validated = $request->validate([
        'nom_enfant.*' => 'required|string',
        'age.*' => 'required|integer|min:0|max:15',
        'date.*' => 'required|date',
        'heure_arrivee.*' => 'required|date_format:H:i',
        'heure_depart.*' => 'required|date_format:H:i|after:heure_arrivee.*',
        'raison_presence.*' => 'required|string|max:255',
    ]);

    $totalAjoutes = 0;

    foreach ($validated['nom_enfant'] as $i => $nom) {
        // Combiner date + heure pour créer les datetimes complets
        $arrivee = Carbon::parse($validated['date'][$i] . ' ' . $validated['heure_arrivee'][$i]);
        $depart = Carbon::parse($validated['date'][$i] . ' ' . $validated['heure_depart'][$i]);

        // Vérif 15 enfants max
        $nb_enfants = ReservationGarderie::where(function ($query) use ($arrivee, $depart) {
            $query->whereBetween('heure_arrivee', [$arrivee, $depart])
                  ->orWhereBetween('heure_depart', [$arrivee, $depart])
                  ->orWhere(function ($q) use ($arrivee, $depart) {
                      $q->where('heure_arrivee', '<=', $arrivee)
                        ->where('heure_depart', '>=', $depart);
                  });
        })->count();

        if ($nb_enfants >= 15) {
            continue; // Ignorer si complet
        }

        $prefix = 'GA' . now()->format('ym');
        $count = ReservationGarderie::where('code_reservation', 'like', "$prefix%")->count() + 1;

        ReservationGarderie::create([
            'code_reservation' => $prefix . str_pad($count, 4, '0', STR_PAD_LEFT),
            'nom_enfant' => $nom,
            'age' => $validated['age'][$i],
            'heure_arrivee' => $arrivee,
            'heure_depart' => $depart,
            'raison_presence' => $validated['raison_presence'][$i],
        ]);

        $totalAjoutes++;
    }

    return redirect()->back()->with('success', "$totalAjoutes enfant(s) réservé(s) avec succès.");
}

}
