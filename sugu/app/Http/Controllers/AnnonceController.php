<?php

namespace App\Http\Controllers;
use App\Models\Annonce;
use App\Models\AnnonceAttribut;
use App\Models\Categorie;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnonceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $annonces = Annonce::with('user', 'categorie')->get();
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
         $annonce = Annonce::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'prix' => $request->prix,
            'user_id' => Auth()->id(),
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

        return redirect()->route('annonces.index');
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
        return view('annonces.edit', compact('annonce'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $annonce = Annonce::findOrFail($id);
        $annonce->update($request->all());
        return redirect()->route('annonces.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Annonce::destroy($id);
        return back();
    }

    public function dashboard()
{
    $user = auth()->user();

    // si admin
    if ($user->is_admin) {
        $annonces = Annonce::with('user')->latest()->get();
        $users = User::count();

        return view('dashboard.admin', compact('annonces', 'users'));
    }

    // utilisateur normal
    $annonces = Annonce::where('user_id', $user->id)->latest()->get();

    return view('dashboard.user', compact('annonces'));
}
}
