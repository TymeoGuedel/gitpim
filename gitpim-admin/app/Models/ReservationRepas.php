<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationRepas extends Model
{
    protected $fillable = [
        'reservation_chambre_id',
        'date',
        'horaire',
        'nb_couverts',
    ];

    public function reservationChambre()
    {
        return $this->belongsTo(ReservationChambre::class);
    }
}
