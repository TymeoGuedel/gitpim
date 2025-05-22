<?php
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReservationKayak;
use Carbon\Carbon;

class ReservationKayakController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_client' => 'required|string',
            'email_client' => 'required|email',
            'date' => 'required|date',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'type_kayak' => 'required|in:simple,double',
            'nb_personnes' => 'required|integer|min:1|max:8',
        ]);

        // Vérification 1h minimum
        $start = Carbon::createFromFormat('H:i', $validated['heure_debut']);
        $end = Carbon::createFromFormat('H:i', $validated['heure_fin']);
        if ($start->diffInMinutes($end) < 60) {
            return back()->withErrors(['heure_fin' => 'La durée minimale est d\'une heure.'])->withInput();
        }

        // Vérification plage horaire : 9h à 16h
        $earliest = Carbon::createFromTime(9, 0);
        $latest = Carbon::createFromTime(16, 0);
        if ($start->lt($earliest) || $end->gt($latest)) {
            return back()->withErrors(['heure_debut' => 'Les horaires doivent être entre 09:00 et 16:00.'])->withInput();
        }

        // Interdiction : 1 personne ne peut pas réserver un kayak double
        if ($validated['type_kayak'] === 'double' && $validated['nb_personnes'] < 2) {
            return back()->withErrors(['nb_personnes' => 'Un kayak double nécessite au moins 2 personnes.'])->withInput();
        }

        // Génération code réservation : KAAAMM000x
        $prefix = 'KA' . now()->format('ym');
        $count = ReservationKayak::where('code_reservation', 'like', "$prefix%")->count() + 1;
        $validated['code_reservation'] = $prefix . str_pad($count, 4, '0', STR_PAD_LEFT);

        ReservationKayak::create($validated);

        return redirect()->back()->with('success', 'Réservation kayak enregistrée avec succès !');
    }
}
