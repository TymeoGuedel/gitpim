<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Models\ReservationChambre;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $total = ReservationChambre::count();
        $totalMer = ReservationChambre::sum('nb_bungalows_mer');
        $totalJardin = ReservationChambre::sum('nb_bungalows_jardin');
        $mois = ReservationChambre::whereMonth('date_debut', now()->month)->count();

        $events = ReservationChambre::all()->map(fn($r) => [
            'id' => $r->id,
            'title' => "{$r->nb_personnes} pers",
            'start' => $r->date_debut,
            'end' => Carbon::parse($r->date_fin)->addDay()->toDateString(),
            'url' => route('admin.reservations_chambres.edit', $r),
            'color' => '#0d6efd'
        ]);

        return view('admin.dashboard', [
            'stats' => [
                'total_chambres' => $total,
                'total_mer' => $totalMer,
                'total_jardin' => $totalJardin,
                'mois' => $mois,
            ],
            'events' => $events
        ]);
    }

    public function createReservation()
    {
        return view('admin.reservations.create', [
            'bungalows_mer' => 5,
            'bungalows_jardin' => 10,
            'chevaux' => [
                'Apache', 'Mustang', 'Sahara', 'Comète', 'Eclair', 'Paillettes',
                'Koné', 'Confiture', 'Foster', 'Inanouï', 'Prince', 'Buster',
                'Charly', 'Sao', 'Tim', 'Tam', 'Nidguep', 'Papirus'
            ],
        ]);
    }

    public function storeReservation(Request $request)
    {
        $request->validate([
            'type_bungalow' => 'required|in:mer,jardin',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'nb_personnes' => 'required|integer|min:1|max:4',
        ]);

        if ($request->type_bungalow === 'mer' && $request->nb_personnes > 2) {
            return back()->withErrors(['nb_personnes' => 'Max 2 personnes pour un bungalow mer.'])->withInput();
        }
        if ($request->type_bungalow === 'jardin' && $request->nb_personnes > 4) {
            return back()->withErrors(['nb_personnes' => 'Max 4 personnes pour un bungalow jardin.'])->withInput();
        }

        // Numéro unique
        $prefix = 'CHA' . now()->format('ym');
        $numero = $prefix . str_pad(ReservationChambre::count() + 1, 4, '0', STR_PAD_LEFT);

        // Chambre
        $reservation = ReservationChambre::create([
            'user_id' => auth()->id(),
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'nb_personnes' => $request->nb_personnes,
            'nb_bungalows_mer' => $request->type_bungalow === 'mer' ? 1 : 0,
            'nb_bungalows_jardin' => $request->type_bungalow === 'jardin' ? 1 : 0,
        ]);

        // Activités (via contrôleurs existants)
        try {
            if ($request->has('with_repas')) {
                App::call('App\Http\Controllers\Admin\ReservationRepasController@store', [
                    'request' => new Request([
                        'reservation_chambre_id' => $reservation->id,
                        'date' => $request->date_debut,
                        'horaire' => '12:00',
                        'nb_couverts' => $request->nb_couverts,
                    ])
                ]);
            }

            if ($request->has('with_randonnee')) {
                App::call('App\Http\Controllers\Admin\ReservationRandonneeController@store', [
                    'request' => new Request([
                        'reservation_chambre_id' => $reservation->id,
                        'date' => $request->date_debut,
                        'nb_cavaliers' => $request->nb_cavaliers,
                        'chevaux' => $request->chevaux,
                    ])
                ]);
            }

            if ($request->has('with_kayak')) {
                App::call('App\Http\Controllers\Admin\ReservationKayakController@store', [
                    'request' => new Request([
                        'reservation_chambre_id' => $reservation->id,
                        'date' => $request->date_debut,
                        'heure_debut' => '09:00',
                        'heure_fin' => '11:00',
                        'type_kayak' => $request->type_kayak,
                        'nb_personnes' => $request->nb_kayak_personnes,
                        'nom_client' => auth()->user()->name,
                        'email_client' => auth()->user()->email,
                    ])
                ]);
            }

            if ($request->has('with_garderie')) {
                App::call('App\Http\Controllers\Admin\ReservationGarderieController@store', [
                    'request' => new Request([
                        'reservation_chambre_id' => $reservation->id,
                        'nom_enfant' => $request->nom_enfant,
                        'age' => $request->age_enfant,
                        'heure_arrivee' => '08:00',
                        'heure_depart' => '12:00',
                        'raison_presence' => 'Activité',
                    ])
                ]);
            }

            if ($request->has('with_bagne')) {
                App::call('App\Http\Controllers\Admin\ReservationBagneController@store', [
                    'request' => new Request([
                        'reservation_chambre_id' => $reservation->id,
                        'date' => $request->date_debut,
                        'horaire' => '14:00',
                        'nb_personnes' => $request->nb_bagne,
                        'nom_client' => auth()->user()->name,
                        'email_client' => auth()->user()->email,
                    ])
                ]);
            }

        } catch (\Exception $e) {
            return back()->withErrors(['global' => $e->getMessage()])->withInput();
        }

        return redirect()->route('admin.dashboard')->with('success', 'Réservation complète enregistrée avec succès.');
    }
}
