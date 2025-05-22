<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReservationRandonneeController extends Controller
{
    public function index()
    {
        return view('randonnee.index', [
            'reservations' => ReservationRandonnee::all()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom_client' => 'required|string',
            'email_client' => 'required|email',
            'date' => 'required|date',
            'nb_personnes' => 'required|integer|max:8'
        ]);

        $data['code_reservation'] = 'RA' . now()->format('ym') . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

        ReservationRandonnee::create($data);
        return redirect()->back()->with('success', 'Réservation enregistrée.');
    }
}

