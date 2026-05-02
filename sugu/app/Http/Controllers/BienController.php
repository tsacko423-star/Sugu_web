<?php
namespace App\Http\Controllers;

use App\Models\Bien;
use App\Models\Emploi;
use App\Models\Voiture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class BienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $biens = Bien::with('user')->get();
        $emplois = Emploi::with('user')->get();
        $voitures = Voiture::with('user')->get();

       return view('bien.index', compact('biens', 'voitures', 'emplois'));
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
            'ville' => 'required|string|max:255',
            'prix' => 'required|numeric',
        ]);

        $paths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $paths[] = $image->store('biens', 'public');
            }
        }

        Bien::create([
            'titre' => $request->titre,
            'ville' => $request->ville,
            'prix' => $request->prix,
            'image' => $paths ? json_encode($paths) : null,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('home')
            ->with('success', 'Bien ajouté avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {        $bien = Bien::with('user')->findOrFail($id);
        return view('bien.show', compact('bien'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {        $bien = Bien::findOrFail($id);
        return view('bien.edit', compact('bien'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $bien = Bien::findOrFail($id);

        $request->validate([
            'titre' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'prix' => 'required|numeric',
        ]);

        $data = [
            'titre' => $request->titre,
            'ville' => $request->ville,
            'prix' => $request->prix,
        ];

        if ($request->hasFile('images')) {
            $paths = [];
            foreach ($request->file('images') as $image) {
                $paths[] = $image->store('biens', 'public');
            }
            $data['image'] = json_encode($paths);
        }

        $bien->update($data);

        return redirect()->route('home')
            ->with('success', 'Bien mis à jour avec succès');
    }

     public function destroy(string $id)
    {
        $bien = Bien::findOrFail($id);
        $bien->delete();

        return redirect()->route('home')
            ->with('success', 'Bien supprimé avec succès');
    }


}