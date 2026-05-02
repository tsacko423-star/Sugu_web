<?php

namespace App\Http\Controllers;

use App\Models\Bien;
use App\Models\Emploi;
use App\Models\Voiture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmploieController extends Controller
{
    // Formulaire admin
    public function create()
    {
        return view('emploie.create');
    }

    // Enregistrer emploi
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'description' => 'required|string',
            'salaire' => 'required|numeric',
        ]);

        Emploi::create([
            'titre' => $request->titre,
            'ville' => $request->ville,
            'description' => $request->description,
            'salaire' => $request->salaire,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('home')
            ->with('success', 'Emploi ajouté avec succès');
    }

    // Page publique
    public function index()
    {
         $biens = Bien::latest()->get();
         $voitures = Voiture::latest()->get();
         $emplois = Emploi::latest()->get();

        return view('emploie.index', compact('biens', 'voitures', 'emplois'));
    }

    public function show($id)
    {
        $emploi = Emploi::findOrFail($id);
        return view('emploie.show', compact('emploi'));
    }

    public function edit($id)
    {
        $emploi = Emploi::findOrFail($id);
        return view('emploie.edit', compact('emploi'));
    }
    
    public function update(Request $request, $id)
    {
        $emploi = Emploi::findOrFail($id);

        $request->validate([
            'titre' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'description' => 'required|string',
            'salaire' => 'required|numeric',
        ]);

        $emploi->update([
            'titre' => $request->titre,
            'ville' => $request->ville,
            'description' => $request->description,
            'salaire' => $request->salaire,
        ]);

        return redirect()->route('home')
            ->with('success', 'Emploi mis à jour avec succès');
    }

    public function destroy($id)
    {
        $emploi = Emploi::findOrFail($id);
        $emploi->delete();

        return redirect()->route('home')
            ->with('success', 'Emploi supprimé avec succès');
    }
}

