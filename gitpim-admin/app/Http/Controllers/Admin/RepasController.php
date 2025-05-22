<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;

class RepasController extends Controller
{
    /**
     * Affiche la liste des tables.
     */
    public function index()
    {
        $tables = Table::all();
        return view('admin.repas.index', compact('tables'));
    }

    /**
     * Affiche le formulaire de création.
     */
    public function create()
    {
        return view('admin.repas.create');
    }

    /**
     * Enregistre une nouvelle table.
     */
    public function store(Request $request)
    {
        $request->validate([
            'capacite' => 'required|integer|min:1',
        ]);

        Table::create([
            'capacite' => $request->capacite,
            'disponible' => true,
        ]);

        return redirect()->route('admin.repas.index')->with('success', 'Table ajoutée avec succès.');
    }

    /**
     * Affiche le formulaire d'édition.
     */
    public function edit(Table $repa)
    {
        return view('admin.repas.edit', ['table' => $repa]);
    }

    /**
     * Met à jour une table existante.
     */
    public function update(Request $request, Table $repa)
    {
        $request->validate([
            'capacite' => 'required|integer|min:1',
        ]);

        $repa->update([
            'capacite' => $request->capacite,
            'disponible' => $request->has('disponible'),
        ]);

        return redirect()->route('admin.repas.index')->with('success', 'Table modifiée.');
    }

    /**
     * Supprime une table.
     */
    public function destroy(Table $repa)
    {
        $repa->delete();

        return redirect()->route('admin.repas.index')->with('success', 'Table supprimée.');
    }
}
