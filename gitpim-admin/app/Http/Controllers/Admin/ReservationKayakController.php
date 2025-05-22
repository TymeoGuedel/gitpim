<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReservationKayak;
use Illuminate\Support\Carbon;


class ReservationKayakController extends Controller
{
    public function create(Request $request)
{
    $reservationId = $request->get('reservation_chambre_id');

    return view('admin.reservations.create_kayak', [
        'reservation_chambre_id' => $reservationId
    ]);
}

   public function store(Request $request)
{
    $validated = $request->validate([
        'reservation_chambre_id' => 'required|exists:reservation_chambres,id',
        'date' => 'required|date',
        'heure_debut' => 'required|date_format:H:i',
        'heure_fin' => 'required|date_format:H:i|after:heure_debut',
        'type_kayak' => 'required|in:simple,double',
        'nb_personnes' => 'required|integer|min:1|max:8',
    ]);

    $start = \Carbon\Carbon::createFromFormat('H:i', $validated['heure_debut']);
    $end = \Carbon\Carbon::createFromFormat('H:i', $validated['heure_fin']);

    // ✅ Durée minimale 1h
    if ($start->diffInMinutes($end) < 60) {
        return back()->withErrors(['heure_fin' => 'La durée minimale est d\'une heure.'])->withInput();
    }

    // ✅ Horaire entre 9h et 16h
    $earliest = \Carbon\Carbon::createFromTime(9, 0);
    $latest = \Carbon\Carbon::createFromTime(16, 0);
    if ($start->lt($earliest) || $end->gt($latest)) {
        return back()->withErrors(['heure_debut' => 'Les horaires doivent être entre 09:00 et 16:00.'])->withInput();
    }

    // ✅ Kayak double = au moins 2 personnes
    if ($validated['type_kayak'] === 'double' && $validated['nb_personnes'] < 2) {
        return back()->withErrors(['nb_personnes' => 'Un kayak double nécessite au moins 2 personnes.'])->withInput();
    }

    // 🔁 Vérif stock disponible pour le créneau
    $reservations = \App\Models\ReservationKayak::where('date', $validated['date'])
        ->where(function ($q) use ($validated) {
            $q->whereBetween('heure_debut', [$validated['heure_debut'], $validated['heure_fin']])
              ->orWhereBetween('heure_fin', [$validated['heure_debut'], $validated['heure_fin']])
              ->orWhere(function ($q2) use ($validated) {
                  $q2->where('heure_debut', '<=', $validated['heure_debut'])
                     ->where('heure_fin', '>=', $validated['heure_fin']);
              });
        })->get();

    $countSimple = $reservations->where('type_kayak', 'simple')->count();
    $countDouble = $reservations->where('type_kayak', 'double')->count();

    if ($validated['type_kayak'] === 'simple' && $countSimple >= 2) {
        return back()->withErrors(['type_kayak' => 'Tous les kayaks simples sont réservés sur ce créneau.'])->withInput();
    }

    if ($validated['type_kayak'] === 'double' && $countDouble >= 3) {
        return back()->withErrors(['type_kayak' => 'Tous les kayaks doubles sont réservés sur ce créneau.'])->withInput();
    }

    // ✅ Code KAAAMM000x
    $prefix = 'KA' . now()->format('ym');
    $count = \App\Models\ReservationKayak::where('code_reservation', 'like', "$prefix%")->count() + 1;
    $validated['code_reservation'] = $prefix . str_pad($count, 4, '0', STR_PAD_LEFT);

    \App\Models\ReservationKayak::create($validated);

    return redirect()->route('admin.reservations_chambres.index')->with('success', 'Sortie kayak ajoutée avec succès.');
}

}
