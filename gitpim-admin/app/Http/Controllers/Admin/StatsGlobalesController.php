<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\ReservationRepas;
use App\Models\ReservationKayak;
use App\Models\ReservationGarderie;
use App\Models\ReservationBagne;
use App\Models\ReservationChambre;

class StatsGlobalesController extends Controller
{
    public function index()
    {
        $jours = collect();
        $from = request('from');
        $to = request('to');

        $repas = ReservationRepas::select(DB::raw('DATE(date) as jour'), DB::raw('SUM(nb_couverts) as total'))
            ->when($from, fn($q) => $q->whereDate('date', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('date', '<=', $to))
            ->groupBy('jour')->get()->keyBy('jour');

        $kayak = ReservationKayak::select(DB::raw('DATE(date) as jour'), DB::raw('COUNT(*) as total'))
            ->when($from, fn($q) => $q->whereDate('date', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('date', '<=', $to))
            ->groupBy('jour')->get()->keyBy('jour');

        $garderie = ReservationGarderie::select(DB::raw('DATE(heure_arrivee) as jour'), DB::raw('COUNT(*) as total'))
            ->when($from, fn($q) => $q->whereDate('heure_arrivee', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('heure_arrivee', '<=', $to))
            ->groupBy('jour')->get()->keyBy('jour');

        $bagne = ReservationBagne::select(DB::raw('DATE(date) as jour'), DB::raw('COUNT(*) as total'))
            ->when($from, fn($q) => $q->whereDate('date', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('date', '<=', $to))
            ->groupBy('jour')->get()->keyBy('jour');

        $dates = $repas->keys()
            ->merge($kayak->keys())
            ->merge($garderie->keys())
            ->merge($bagne->keys())
            ->unique()->sort();

        foreach ($dates as $jour) {
            $jours->push([
                'date' => $jour,
                'repas' => $repas[$jour]->total ?? 0,
                'kayak' => $kayak[$jour]->total ?? 0,
                'garderie' => $garderie[$jour]->total ?? 0,
                'bagne' => $bagne[$jour]->total ?? 0,
            ]);
        }

        $chambresOccupées = ReservationChambre::select(DB::raw('SUM(nb_bungalows_mer) as mer'), DB::raw('SUM(nb_bungalows_jardin) as jardin'))
            ->when($from, fn($q) => $q->whereDate('date_debut', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('date_debut', '<=', $to))
            ->first();

        $stats = [
            'chambres' => ReservationChambre::count(),
            'repas' => ReservationRepas::count(),
            'kayak' => ReservationKayak::count(),
            'garderie' => ReservationGarderie::count(),
            'bagne' => ReservationBagne::count(),
            'bungalows_mer_utilisés' => $chambresOccupées->mer ?? 0,
            'bungalows_jardin_utilisés' => $chambresOccupées->jardin ?? 0,
            'bungalows_mer_total' => 5,
            'bungalows_jardin_total' => 10,
        ];

        return view('admin.stats_globales', [
            'jours' => $jours,
            'stats' => $stats,
            'from' => $from,
            'to' => $to
        ]);
    }
}
