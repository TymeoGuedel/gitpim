<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReservationChambre;
use Carbon\Carbon;

class ReservationChambreSeeder extends Seeder
{
    public function run(): void
    {
        // Supprime les anciennes pour éviter les doublons
        ReservationChambre::query()->delete();


        for ($i = 1; $i <= 5; $i++) {
            $start = Carbon::now()->addDays($i * 2);
            $end = (clone $start)->addDays(2);

            ReservationChambre::create([
                'nb_personnes' => rand(1, 6),
                'date_debut' => $start->format('Y-m-d'),
                'date_fin' => $end->format('Y-m-d'),
            ]);
        }
    }
}
