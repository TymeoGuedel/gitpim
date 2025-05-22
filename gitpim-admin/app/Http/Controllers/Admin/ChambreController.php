<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chambre;
use Illuminate\Http\Request;

class ChambreController extends Controller
{
    /**
     * Affiche toutes les chambres.
     */
    public function index()
    {
        $chambres = Chambre::all();
        return view('admin.chambres.index', compact('chambres'));
    }

    /**
     * Affiche le formulaire de création.
     */
    public function create()
    {
        return view('admin.chambres.create');
    }

    /**
     * Enregistre une nouvelle chambre.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:mer,jardin',
            'capacite' => 'required|integer|min:1',
        ]);

        Chambre::create($request->all());

        return redirect()->route('admin.chambres.index')->with('success', 'Chambre créée avec succès.');
    }

    /**
     * Affiche le formulaire de modification.
     */
    public function edit(Chambre $chambre)
    {
        return view('admin.chambres.edit', compact('chambre'));
    }

    /**
     * Met à jour une chambre.
     */
    public function update(Request $request, Chambre $chambre)
    {
        $request->validate([
            'type' => 'required|in:mer,jardin',
            'capacite' => 'required|integer|min:1',
        ]);

        $chambre->update($request->all());

        return redirect()->route('admin.chambres.index')->with('success', 'Chambre modifiée avec succès.');
    }

    /**
     * Supprime une chambre.
     */
    public function destroy(Chambre $chambre)
    {
        $chambre->delete();

        return redirect()->route('admin.chambres.index')->with('success', 'Chambre supprimée.');
    }
}
