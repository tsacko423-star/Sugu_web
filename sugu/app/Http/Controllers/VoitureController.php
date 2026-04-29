<?php

namespace App\Http\Controllers;

use App\Models\Bien;
use App\Models\Emploi;
use App\Models\Voiture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoitureController extends Controller
{
    // Formulaire admin
    public function create()
    {
        return view('voitures.create');
    }

    // Enregistrer voiture
    public function store(Request $request)
    {
        $request->validate([
            'marque' => 'required|string|max:255',
            'modele' => 'required|string|max:255',
            'annee' => 'required|integer',
            'prix' => 'required|numeric',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Upload image
        $imagePath = $request->file('image')->store('voitures', 'public');

        // Création
        Voiture::create([
            'marque' => $request->marque,
            'modele' => $request->modele,
            'annee' => $request->annee,
            'prix' => $request->prix,
            'image' => $imagePath,
            'user_id' => Auth::id() 
        ]);

        // Redirection vers page publique
        return redirect()->route('home')
            ->with('success', 'Voiture ajoutée avec succès');
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

