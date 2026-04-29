<?php
namespace App\Http\Controllers;

use App\Models\Bien;
use App\Models\Emploi;
use App\Models\Voiture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class Bien_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $biens = Bien::with('user')->get();
        $emplois = Emploi::with('user')->get();
        $voitures = Voiture::with('user')->get();

       return view('home', compact('biens', 'voitures', 'emplois'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('bien.create'); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric',
        ]);
          $paths = [];

         if ($request->hasFile('images')) {
         foreach ($request->file('images') as $image) {
            $paths[] = $image->store('voitures', 'public');
         }
          }

        Bien::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'prix' => $request->prix,
            'image' => json_encode($paths),
            'numero' => $request->numero,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('home')
            ->with('success', 'Bien ajouté avec succès');
    }
}