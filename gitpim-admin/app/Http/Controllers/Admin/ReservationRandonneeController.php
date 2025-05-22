<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReservationRandonnee;


class ReservationRandonneeController extends Controller
{
    public function create(Request $request)
{
    $reservationId = $request->get('reservation_chambre_id');

    return view('admin.reservations.create_randonnee', [
        'reservation_chambre_id' => $reservationId
    ]);
}

  public function store(Request $request)
{
    $request->validate([
        'reservation_chambre_id' => 'required|exists:reservation_chambres,id',
        'date' => 'required|date',
        'nb_cavaliers' => 'required|integer|min:1|max:8',
        'chevaux' => 'nullable|string',
    ]);

    ReservationRandonnee::create($request->all());

    return redirect()->route('admin.reservations_chambres.index')->with('success', 'Randonnée ajoutée avec succès.');
}

}
