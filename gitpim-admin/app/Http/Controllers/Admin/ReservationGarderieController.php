<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReservationGarderie;
use Illuminate\Support\Carbon;


class ReservationGarderieController extends Controller
{
  public function store(Request $request)
{
    $validated = $request->validate([
        'reservation_chambre_id' => 'required|exists:reservation_chambres,id',
        'nom_enfant' => 'required|string',
        'age' => 'required|integer|min:0|max:15',
        'heure_arrivee' => 'required|date_format:H:i',
        'heure_depart' => 'required|date_format:H:i|after:heure_arrivee',
        'date' => 'required|date',
        'raison_presence' => 'nullable|string|max:255',
    ]);

    $arrivee = \Carbon\Carbon::parse($validated['date'] . ' ' . $validated['heure_arrivee']);
    $depart = \Carbon\Carbon::parse($validated['date'] . ' ' . $validated['heure_depart']);

    // ✅ Vérif : pas plus de 15 enfants sur ce créneau
    $nb_enfants = \App\Models\ReservationGarderie::where(function ($query) use ($arrivee, $depart) {
        $query->whereBetween('heure_arrivee', [$arrivee, $depart])
              ->orWhereBetween('heure_depart', [$arrivee, $depart])
              ->orWhere(function ($q) use ($arrivee, $depart) {
                  $q->where('heure_arrivee', '<=', $arrivee)
                    ->where('heure_depart', '>=', $depart);
              });
    })->count();

    if ($nb_enfants >= 15) {
        return back()->withErrors(['heure_arrivee' => 'Ce créneau est complet (15 enfants max).'])->withInput();
    }

    // ✅ Générer code : GAAAMM000x
    $prefix = 'GA' . now()->format('ym');
    $count = \App\Models\ReservationGarderie::where('code_reservation', 'like', "$prefix%")->count() + 1;
    $code = $prefix . str_pad($count, 4, '0', STR_PAD_LEFT);

    \App\Models\ReservationGarderie::create([
        'reservation_chambre_id' => $validated['reservation_chambre_id'],
        'code_reservation' => $code,
        'nom_enfant' => $validated['nom_enfant'],
        'age' => $validated['age'],
        'heure_arrivee' => $arrivee,
        'heure_depart' => $depart,
        'raison_presence' => $validated['raison_presence'],
    ]);

    return redirect()->route('admin.reservations_chambres.index')->with('success', 'Enfant ajouté à la garderie avec succès.');
}

}
