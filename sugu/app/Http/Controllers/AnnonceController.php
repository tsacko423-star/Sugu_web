<?php

namespace App\Http\Controllers;
use App\Models\Annonce;
use App\Models\AnnonceAttribut;
use App\Models\Categorie;
use App\Http\Requests\StoreAnnonceRequest;
use App\Http\Requests\UpdateAnnonceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnnonceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $annonces = Annonce::with('categorie')
            ->when($request->routeIs('annonces.index') && Auth::check() && Auth::user()->role !== 'admin', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->orderByDesc('created_at')
            ->get();

        return view('annonces.index', compact('annonces'));
    }

    public function search(Request $request)
    {
        $query = trim($request->query('q', ''));

        $annonces = Annonce::with('user', 'categorie')
            ->when($query, function ($builder, $value) {
                $builder->where(function ($sub) use ($value) {
                    $sub->where('titre', 'like', "%{$value}%")
                        ->orWhere('description', 'like', "%{$value}%")
                        ->orWhereHas('categorie', function ($q) use ($value) {
                            $q->where('name', 'like', "%{$value}%");
                        });
                });
            })
            ->orderByDesc('created_at')
            ->get();

        return view('annonces.index', compact('annonces'));
    }

    public function category(string $id)
    {
        $categorie = Categorie::findOrFail($id);
        $annonces = Annonce::with('user', 'categorie')
            ->where('categorie_id', $id)
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
    public function store(StoreAnnonceRequest $request)
    {
        $imagePaths = [];
        
        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('annonces', 'public');
                $imagePaths[] = $path;
            }
        }
        
        $annonce = Annonce::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'prix' => $request->prix,
            'user_id' => Auth::id(),
            'categorie_id' => $request->categorie_id,
            'images' => $imagePaths,
        ]);
        
        // ajouter attributs dynamiques
        if($request->attributs && isset($request->attributs['nom'])){
            foreach($request->attributs['nom'] as $index => $nom){
                $valeur = $request->attributs['valeur'][$index] ?? '';
                if($nom && $valeur){
                    AnnonceAttribut::create([
                        'annonce_id' => $annonce->id,
                        'nom' => $nom,
                        'valeur' => $valeur,
                    ]);
                }
            }
        }

        return redirect()->route('annonces.index')->with('success', 'Annonce créée avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $annonce = Annonce::with('user', 'categorie', 'annonceAttributs')->findOrFail($id);
        return view('annonces.show', compact('annonce'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       $annonce = Annonce::with('annonceAttributs')->findOrFail($id);
       $this->authorizeAnnonceOwner($annonce);

       $categories = Categorie::all();
        return view('annonces.edit', compact('annonce', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnnonceRequest $request, string $id)
    {
        $annonce = Annonce::findOrFail($id);
        $this->authorizeAnnonceOwner($annonce);
        
        $imagePaths = $annonce->images ?? [];
        
        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('annonces', 'public');
                $imagePaths[] = $path;
            }
        }
        
        $annonce->update([
            'titre' => $request->titre,
            'description' => $request->description,
            'prix' => $request->prix,
            'categorie_id' => $request->categorie_id,
            'images' => $imagePaths,
        ]);

        // Supprimer les anciens attributs
        $annonce->annonceAttributs()->delete();

        // Ajouter les nouveaux attributs
        if($request->attributs && isset($request->attributs['nom'])){
            foreach($request->attributs['nom'] as $index => $nom){
                $valeur = $request->attributs['valeur'][$index] ?? '';
                if($nom && $valeur){
                    AnnonceAttribut::create([
                        'annonce_id' => $annonce->id,
                        'nom' => $nom,
                        'valeur' => $valeur,
                    ]);
                }
            }
        }

        return redirect()->route('annonces.index')->with('success', 'Annonce modifiée avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $annonce = Annonce::findOrFail($id);
        $this->authorizeAnnonceOwner($annonce);
        
        // Delete images
        if ($annonce->images) {
            foreach ($annonce->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }
        
        $annonce->delete();
        return back();
    }

    private function authorizeAnnonceOwner(Annonce $annonce): void
    {
        if (Auth::user()->role === 'admin') {
            return;
        }

        if ((int) $annonce->user_id !== (int) Auth::id()) {
            abort(403, 'Accès refusé');
        }
    }

 
}
