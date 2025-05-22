<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReservationChambre extends Model
{
    use HasFactory;

protected $fillable = [
    'user_id',
    'date_debut',
    'date_fin',
    'nb_personnes',
    'nb_bungalows_mer',
    'nb_bungalows_jardin'
];


    // 🔗 Relation avec l'utilisateur (automatiquement via user_id)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔗 Relations avec chaque type de réservation liée
    public function reservationRepas()
    {
        return $this->hasMany(ReservationRepas::class);
    }

    public function reservationKayaks()
    {
        return $this->hasMany(ReservationKayak::class);
    }

    public function reservationGarderies()
    {
        return $this->hasMany(ReservationGarderie::class);
    }

    public function reservationRandonnees()
    {
        return $this->hasMany(ReservationRandonnee::class);
    }

    public function reservationBagnes()
    {
        return $this->hasMany(ReservationBagne::class);
    }
}
