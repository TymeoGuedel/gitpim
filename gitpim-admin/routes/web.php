<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    AdminController,
    ChambreController,
    RepasController,
    RandonneeController,
    GarderieController,
    BagneController,
    ReservationChambreController,
    ReservationRepasController,
    ReservationRandonneeController,
    ReservationKayakController,
    ReservationGarderieController,
    ReservationBagneController,
    StatsGlobalesController
};
use App\Http\Controllers\Public\{
    ReservationKayakController as PublicReservationKayakController,
    ReservationGarderieController as PublicReservationGarderieController,
    ReservationBagneController as PublicReservationBagneController
};

// 🏠 Accueil public
Route::get('/', fn() => 'Bienvenue sur l’accueil');

// 📋 Formulaires publics
Route::get('/reserver/garderie', fn() => view('public.reservations.create_garderie'))->name('garderie.create');
Route::post('/reserver/garderie', [PublicReservationGarderieController::class, 'store'])->name('garderie.store');

Route::get('/reserver/bagne', fn() => view('public.reservations.create_bagne'))->name('bagne.create');
Route::post('/reserver/bagne', [PublicReservationBagneController::class, 'store'])->name('bagne.store');

// 👤 Dashboard utilisateur connecté
Route::get('/dashboard', fn() => 'Bienvenue sur le dashboard')->middleware(['auth', 'verified'])->name('dashboard');

// 👥 Routes utilisateur connecté
Route::middleware('auth')->group(function () {
    Route::get('/profile', fn() => 'Page de profil')->name('profile.edit');
});

// 🔐 Routes ADMIN
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // 🧭 Dashboard admin
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // 📝 Réservation centralisée
    Route::get('/reservations/create', [AdminController::class, 'createReservation'])->name('reservations.create');
    Route::post('/reservations/store', [AdminController::class, 'storeReservation'])->name('reservations.store');

    // 🔗 Redirection vers choix d'activités
    Route::get('/reservations_chambres/{reservation}/activites', [ReservationChambreController::class, 'activites'])->name('reservations_chambres.activites');

    // 📊 Statistiques
    Route::get('/stats-globales', [StatsGlobalesController::class, 'index'])->name('stats.globales');
    Route::get('/statistiques', [AdminController::class, 'stats'])->name('stats');

    // 📆 Calendrier
    Route::get('/reservations_chambres/calendar', [ReservationChambreController::class, 'calendar'])->name('reservations_chambres.calendar');

    // 📦 CRUD (ressources)
    Route::resource('chambres', ChambreController::class);
    Route::resource('repas', RepasController::class);
    Route::resource('randonnees', RandonneeController::class);
    Route::resource('garderies', GarderieController::class);
    Route::resource('bagnes', BagneController::class);

    // 📝 Réservations par activité
    Route::resource('reservations_chambres', ReservationChambreController::class);
    Route::resource('reservations_repas', ReservationRepasController::class);
    Route::resource('reservations_randonnees', ReservationRandonneeController::class);

  // 🔗 Routes spécifiques d'ajout (création directe)
Route::get('/reservations_repas/create', [ReservationRepasController::class, 'create'])->name('reservations_repas.create');
Route::post('/reservations_repas', [ReservationRepasController::class, 'store'])->name('admin.reservations_repas.store');

Route::get('/reservations_randonnees/create', [ReservationRandonneeController::class, 'create'])->name('reservations_randonnees.create');
Route::post('/reservations_randonnees', [ReservationRandonneeController::class, 'store'])->name('admin.reservations_randonnees.store');

Route::get('/reservations_kayak/create', [ReservationKayakController::class, 'create'])->name('reservations_kayak.create');
Route::post('/reservations_kayak', [ReservationKayakController::class, 'store'])->name('admin.reservations_kayak.store');

Route::get('/reservations_garderie/create', [ReservationGarderieController::class, 'create'])->name('reservations_garderie.create');
Route::post('/reservations_garderie', [ReservationGarderieController::class, 'store'])->name('admin.reservations_garderie.store');

Route::get('/reservations_bagne/create', [ReservationBagneController::class, 'create'])->name('reservations_bagne.create');
Route::post('/reservations_bagne', [ReservationBagneController::class, 'store'])->name('admin.reservations_bagne.store');

});

// 🔐 Auth Breeze
require __DIR__.'/auth.php';
