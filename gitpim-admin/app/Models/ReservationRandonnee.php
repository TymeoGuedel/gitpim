<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationRandonnee extends Model
{
    use HasFactory;

    protected $fillable = [
        'code_reservation',
        'nom_client',
        'email_client',
        'date',
        'nb_personnes'
    ];
    public function reservationChambre()
{
    return $this->belongsTo(ReservationChambre::class);
}

}

