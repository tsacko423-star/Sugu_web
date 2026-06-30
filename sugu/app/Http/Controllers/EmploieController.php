<?php

namespace App\Http\Controllers;

use App\Models\Emploi;
use Illuminate\Http\Request;

class EmploieController extends Controller
{
    public function index()
    {
        $emplois = Emploi::with('user')->latest()->get();

        return view('emploie.index', compact('emplois'));
    }

    public function create()
    {
        return view('emploie.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'ville' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'salaire' => ['required', 'numeric', 'min:0'],
        ]);

        $validated['user_id'] = $request->user()->id;

        Emploi::create($validated);

        return redirect()->route('emplois.index')->with('success', 'Emploi cree avec succes.');
    }

    public function show($id)
    {
        $emploi = Emploi::with('user')->findOrFail($id);

        return view('emploie.show', compact('emploi'));
    }

    public function edit($id)
    {
        $emploi = Emploi::findOrFail($id);

        return view('emploie.edit', compact('emploi'));
    }

    public function update(Request $request, $id)
    {
        $emploi = Emploi::findOrFail($id);
        $validated = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'ville' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'salaire' => ['required', 'numeric', 'min:0'],
        ]);

        $emploi->update($validated);

        return redirect()->route('emplois.index')->with('success', 'Emploi modifie avec succes.');
    }

    public function destroy($id)
    {
        Emploi::findOrFail($id)->delete();

        return redirect()->route('emplois.index')->with('success', 'Emploi supprime avec succes.');
    }
}
