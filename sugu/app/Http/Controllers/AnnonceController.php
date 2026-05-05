<?php

namespace App\Http\Controllers;
use App\Models\Annonce;
use App\Models\AnnonceAttribut;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnonceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $annonces = Annonce::with('user', 'categorie')
            ->orderByDesc('created_at')
            ->get();

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
