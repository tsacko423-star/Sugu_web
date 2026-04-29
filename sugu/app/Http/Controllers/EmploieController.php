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
            'description' => 'required|string',
            'salaire' => 'required|numeric',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Upload image
        $imagePath = $request->file('image')->store('emploie', 'public');

        // Création
        Emploi::create([
            'marque' => $request->marque,
            'modele' => $request->modele,
            'annee' => $request->annee,
            'prix' => $request->prix,
            'image' => $imagePath,
            'user_id' => Auth::id() 
        ]);

        // Redirection vers page publique
        return redirect()->route('home')
            ->with('success', ' ajoutée avec succès');
    }

    // Page publique
    public function index()
    {
         $biens = Bien::latest()->get();
    $voitures = Voiture::latest()->get();
    $emplois = Emploi::latest()->get();

    return view('home', compact('biens', 'voitures', 'emplois'));
    }
}

