<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReservationChambre;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationChambreController extends Controller
{
    public function index()
    {
        $reservations = ReservationChambre::all();
        return view('admin.reservations_chambres.index', compact('reservations'));
    }

    public function create()
    {
        return view('admin.reservations_chambres.create');
    }

   public function store(Request $request)
{
    $request->validate([
        'date_debut' => 'required|date|after_or_equal:today',
        'date_fin' => 'required|date|after:date_debut',
        'nb_personnes' => 'required|integer|min:1',
        'nb_bungalows_mer' => 'nullable|integer|min:0|max:5',
        'nb_bungalows_jardin' => 'nullable|integer|min:0|max:10',
    ]);

    $nbPersonnes = $request->input('nb_personnes');

    if ($request->filled('nb_bungalows_mer') && $request->filled('nb_bungalows_jardin')) {
        $capacite = ($request->nb_bungalows_mer * 2) + ($request->nb_bungalows_jardin * 4);

        if ($capacite < $nbPersonnes) {
            return back()->withErrors(['nb_personnes' => 'La capacité sélectionnée est insuffisante pour loger tout le groupe.'])->withInput();
        }

        $mer = $request->nb_bungalows_mer;
        $jardin = $request->nb_bungalows_jardin;
    } else {
        $repartition = $this->calculerRepartitionChambres($nbPersonnes);

        if (!$repartition) {
            return back()->withErrors(['nb_personnes' => 'Impossible de répartir ce groupe automatiquement.'])->withInput();
        }

        $mer = $repartition['mer'];
        $jardin = $repartition['jardin'];
    }

    // 🏠 Création
    $reservation = ReservationChambre::create([
        'user_id' => auth()->id(),
        'date_debut' => $request->input('date_debut'),
        'date_fin' => $request->input('date_fin'),
        'nb_personnes' => $nbPersonnes,
        'nb_bungalows_mer' => $mer,
        'nb_bungalows_jardin' => $jardin,
    ]);

    // ✅ REDIRECTION VERS LA PAGE ACTIVITÉS
    return redirect()->route('admin.reservations_chambres.activites', $reservation->id);
}
public function activites(ReservationChambre $reservation)
{
    return view('admin.reservations_chambres.activites', [
        'reservation' => $reservation
    ]);
}

}
