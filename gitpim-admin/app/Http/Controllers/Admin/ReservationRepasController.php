<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReservationRepas;


class ReservationRepasController extends Controller
{
    public function index()
    {
        $repas = ReservationRepas::with('reservationChambre')->get();
        return view('admin.reservations_repas.index', compact('repas'));
    }

    public function create()
    {
        $reservations = ReservationChambre::all();
        return view('admin.reservations_repas.create', compact('reservations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'reservation_chambre_id' => 'required|exists:reservation_chambres,id',
            'date' => 'required|date',
            'horaire' => 'required',
            'nb_couverts' => 'required|integer|min:1',
        ]);

        ReservationRepas::create($request->all());

        return redirect()->route('admin.reservations_repas.index')->with('success', 'Repas réservé.');
    }

    public function edit(ReservationRepas $reservation_repa)
    {
        $reservations = ReservationChambre::all();
        return view('admin.reservations_repas.edit', [
            'repa' => $reservations_repa,
            'reservations' => $reservations,
        ]);
    }

    public function update(Request $request, ReservationRepas $reservations_repa)
    {
        $request->validate([
            'reservation_chambre_id' => 'required|exists:reservation_chambres,id',
            'date' => 'required|date',
            'horaire' => 'required',
            'nb_couverts' => 'required|integer|min:1',
        ]);

        $reservations_repa->update($request->all());

        return redirect()->route('admin.reservations_repas.index')->with('success', 'Réservation modifiée.');
    }

    public function destroy(ReservationRepas $reservations_repa)
    {
        $reservations_repa->delete();
        return redirect()->route('admin.reservations_repas.index')->with('success', 'Supprimée.');
    }
}
