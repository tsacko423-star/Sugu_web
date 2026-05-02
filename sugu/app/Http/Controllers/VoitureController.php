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
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Upload image si fournie
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('voitures', 'public');
        }

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

        return view('voitures.index', compact('biens', 'voitures', 'emplois'));
    }

    public function show($id)
    {
        $voiture = Voiture::findOrFail($id);
        return view('voitures.show', compact('voiture'));
    }

    public function edit($id)
    {
        $voiture = Voiture::findOrFail($id);
        return view('voitures.edit', compact('voiture'));
    }

    public function update(Request $request, $id)
    {
        $voiture = Voiture::findOrFail($id);

        $request->validate([
            'marque' => 'required|string|max:255',
            'modele' => 'required|string|max:255',
            'annee' => 'required|integer',
            'prix' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Mise à jour des champs
        $data = [
            'marque' => $request->marque,
            'modele' => $request->modele,
            'annee' => $request->annee,
            'prix' => $request->prix,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('voitures', 'public');
        }

        $voiture->update($data);

        // Redirection vers page publique
        return redirect()->route('home')
            ->with('success', 'Voiture mise à jour avec succès');
    }

    public function destroy($id)
    {
        $voiture = Voiture::findOrFail($id);
        $voiture->delete();

        return redirect()->route('home')
            ->with('success', 'Voiture supprimée avec succès');

     }          
}

