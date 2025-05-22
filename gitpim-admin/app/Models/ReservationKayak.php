<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationKayak extends Model
{
    use HasFactory;

    protected $fillable = [
        'code_reservation',
        'nom_client',
        'email_client',
        'date',
        'heure_debut',
        'heure_fin',
        'type_kayak',
        'nb_personnes'
    ];
    public function reservationChambre()
{
    return $this->belongsTo(ReservationChambre::class);
}

}
