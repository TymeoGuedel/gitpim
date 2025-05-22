<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReservationBagne;
use Illuminate\Support\Carbon;


class ReservationBagneController extends Controller
{
    public function create(Request $request)
{
    $reservationId = $request->get('reservation_chambre_id');

    return view('admin.reservations.create_bagne', [
        'reservation_chambre_id' => $reservationId
    ]);
}

  public function store(Request $request)
{
    $validated = $request->validate([
        'reservation_chambre_id' => 'required|exists:reservation_chambres,id',
        'date' => 'required|date',
        'horaire' => 'required|in:matin,apres-midi',
        'nb_personnes' => 'required|integer|min:1|max:10',
    ]);

    $date = \Carbon\Carbon::parse($validated['date']);

    // ✅ Vérification : uniquement samedi ou dimanche
    if (!$date->isWeekend()) {
        return back()->withErrors(['date' => 'Les visites sont uniquement possibles le samedi et le dimanche.'])->withInput();
    }

    // ✅ Vérification : capacité max 10
    $nbInscrits = \App\Models\ReservationBagne::where('date', $validated['date'])
        ->where('horaire', $validated['horaire'])
        ->sum('nb_personnes');

    if (($nbInscrits + $validated['nb_personnes']) > 10) {
        return back()->withErrors(['nb_personnes' => 'La session est complète ou dépasse la capacité de 10 personnes.'])->withInput();
    }

    // ✅ Code unique BAAAMM000x
    $prefix = 'BA' . now()->format('ym');
    $count = \App\Models\ReservationBagne::where('code_reservation', 'like', "$prefix%")->count() + 1;
    $validated['code_reservation'] = $prefix . str_pad($count, 4, '0', STR_PAD_LEFT);

    \App\Models\ReservationBagne::create($validated);

    return redirect()->route('admin.reservations_chambres.index')->with('success', 'Visite du bagne ajoutée avec succès.');
}


}
