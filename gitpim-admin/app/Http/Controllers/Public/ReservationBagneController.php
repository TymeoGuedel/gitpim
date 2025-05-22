<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReservationBagne;
use Carbon\Carbon;

class ReservationBagneController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_client' => 'required|string',
            'email_client' => 'required|email',
            'date' => 'required|date',
            'horaire' => 'required|in:matin,apres-midi',
            'nb_personnes' => 'required|integer|min:1|max:10',
        ]);

        $date = Carbon::parse($validated['date']);

        // ✅ Vérification 1 : Samedi ou Dimanche uniquement
        if (!$date->isWeekend()) {
            return back()->withErrors(['date' => 'Les visites sont uniquement possibles le samedi et le dimanche.'])->withInput();
        }

        // ✅ Vérification 2 : Capacité max 10 visiteurs par session
        $nbInscrits = ReservationBagne::where('date', $validated['date'])
            ->where('horaire', $validated['horaire'])
            ->sum('nb_personnes');

        if (($nbInscrits + $validated['nb_personnes']) > 10) {
            return back()->withErrors(['nb_personnes' => 'La session est complète ou le nombre dépasse la capacité de 10 personnes.'])->withInput();
        }

        // ✅ Génération du code : BAAAMM000x
        $prefix = 'BA' . now()->format('ym');
        $count = ReservationBagne::where('code_reservation', 'like', "$prefix%")->count() + 1;
        $validated['code_reservation'] = $prefix . str_pad($count, 4, '0', STR_PAD_LEFT);

        ReservationBagne::create($validated);

        return redirect()->back()->with('success', 'Réservation enregistrée pour la visite du bagne !');
    }
}
