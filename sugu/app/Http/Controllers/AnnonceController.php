<?php

namespace App\Http\Controllers;
use App\Models\Annonce;
use App\Models\AnnonceAttribut;
use App\Models\Categorie;
use App\Models\User;
use App\Models\Bien;
use App\Models\Voiture;
use App\Models\Emploi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnonceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer toutes les annonces de toutes les catégories
        $biens = Bien::with('user')->get()->map(function($bien) {
            return (object) [
                'id' => $bien->id,
                'titre' => $bien->titre,
                'description' => $bien->description,
                'prix' => $bien->prix,
                'image_url' => $bien->image_url,
                'created_at' => $bien->created_at,
                'user' => $bien->user,
                'type' => 'immobilier',
                'route_prefix' => 'biens'
            ];
        });

        $voitures = Voiture::with('user')->get()->map(function($voiture) {
            return (object) [
                'id' => $voiture->id,
                'titre' => $voiture->marque . ' ' . $voiture->modele,
                'description' => 'Voiture ' . $voiture->marque . ' ' . $voiture->modele . ' - ' . $voiture->annee,
                'prix' => $voiture->prix,
                'image_url' => $voiture->image ? asset('storage/' . $voiture->image) : null,
                'created_at' => $voiture->created_at,
                'user' => $voiture->user,
                'type' => 'voiture',
                'route_prefix' => 'voitures'
            ];
        });

        $emplois = Emploi::with('user')->get()->map(function($emploi) {
            return (object) [
                'id' => $emploi->id,
                'titre' => $emploi->titre,
                'description' => $emploi->description,
                'prix' => $emploi->salaire,
                'image_url' => null,
                'created_at' => $emploi->created_at,
                'user' => $emploi->user,
                'type' => 'emploi',
                'route_prefix' => 'emplois'
            ];
        });

        // Fusionner toutes les annonces et trier par date de création
        $annonces = collect([...$biens, ...$voitures, ...$emplois])
            ->sortByDesc('created_at')
            ->values();

        return view('annonces.index', compact('annonces'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $categories = Categorie::all();
        return view('annonces.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'categorie_id' => 'required|exists:categories,id',
        ]);

         $annonce = Annonce::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'prix' => $request->prix,
            'user_id' => Auth::id(),
            'categorie_id' => $request->categorie_id,
        ]);
          // ajouter attributs dynamiques
        if($request->attributs){
            foreach($request->attributs as $key => $value){
                AnnonceAttribut::create([
                    'annonce_id' => $annonce->id,
                    'nom' => $key,
                    'valeur' => $value,
                ]);
            }
        }

        return redirect()->route('annonces.index')->with('success', 'Annonce créée avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $annonce = Annonce::with('user', 'categorie')->findOrFail($id);
        return view('annonces.show', compact('annonce'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       $annonce = Annonce::findOrFail($id);
       $categories = Categorie::all();
        return view('annonces.edit', compact('annonce', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'categorie_id' => 'required|exists:categories,id',
        ]);

        $annonce = Annonce::findOrFail($id);
        $annonce->update($request->only(['titre', 'description', 'prix', 'categorie_id']));
        return redirect()->route('annonces.index')->with('success', 'Annonce modifiée avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Annonce::destroy($id);
        return back();
    }

 
}
