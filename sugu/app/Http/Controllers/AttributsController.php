<?php

namespace App\Http\Controllers;

use App\Models\Attribut;
use Illuminate\Http\Request;

class AttributsController extends Controller
{
    public function index()
    {
        $attributs = Attribut::latest()->get();

        return view('attributs.index', compact('attributs'));
    }

    public function create()
    {
        return view('attributs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255', 'unique:attributs,nom'],
        ]);

        Attribut::create($validated);

        return redirect()->route('attributs.index')->with('success', 'Attribut cree avec succes.');
    }

    public function show($id)
    {
        $attribut = Attribut::findOrFail($id);

        return view('attributs.show', compact('attribut'));
    }

    public function edit($id)
    {
        $attribut = Attribut::findOrFail($id);

        return view('attributs.edit', compact('attribut'));
    }

    public function update(Request $request, $id)
    {
        $attribut = Attribut::findOrFail($id);
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255', 'unique:attributs,nom,' . $attribut->id],
        ]);

        $attribut->update($validated);

        return redirect()->route('attributs.index')->with('success', 'Attribut modifie avec succes.');
    }

    public function destroy($id)
    {
        Attribut::findOrFail($id)->delete();

        return redirect()->route('attributs.index')->with('success', 'Attribut supprime avec succes.');
    }
}
