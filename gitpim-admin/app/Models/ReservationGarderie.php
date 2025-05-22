<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationGarderie extends Model
{
    use HasFactory;

    protected $fillable = [
        'code_reservation',
        'nom_enfant',
        'age',
        'heure_arrivee',
        'heure_depart',
        'raison_presence'
    ];
    public function reservationChambre()
{
    return $this->belongsTo(ReservationChambre::class);
}

}
